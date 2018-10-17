/* #############################
 * OSU:CS Senior Capstone 2018
 * Green Smart Gardening Project
 * Developed By:
 *    Brandon Ellis
 *    Jiayu Han
 *    Jack Neff
 * ############################## */


//Extra Comment Layout
/* ##############
 * 
 * ############## */
 
/* #############
 * Library Calls
 * ############# */
//Wifi Connection
#include <WiFi101.h>

//Allow Communication Via Pins
#include <Wire.h>
#include <SPI.h>

//Communication with BME180 Sensor
#include <Adafruit_BME280.h>
#include <Adafruit_Sensor.h>

//Scheduling System
#include <TaskScheduler.h>
#include <TaskSchedulerDeclarations.h>

//Header Files
#include "secrets.h"


/* ############################################################
 * Globals - BME
 *    These are used for making connections to the BME280
 *    At this point all connection methods are left in to 
 *      make swapping during development easier
 * 
 * //BME:
 * //Via I2C
 * // Adafruit_BME280 bme;
 * //Via SPI (Hardware)
 * // #define BME_CS 10
 * // Adafruit_BME280 bme(BME_CS);
 * //Via SPI (Software)
 * // #define BME_SCK 13
 * // #define BME_MISO 12
 * // #define BME_MOSI 11
 * // #define BME_CS 10
 * // Adafruit_BME280 bme(BME_CS, BME_MOSI, BME_MISO, BME_SCK);
 * 
 * //#define SEALEVELPRESSURE_HPA (1000.25) // need to change the relative HPA for acurate measuring
 *  used for altitude
 * ############################################################ */
Adafruit_BME280 bme; //I2C

/* ##########################################
 * Globals - Variables
 * 
 * HOUR   - 1 hour   = 2,600,000 milliseconds
 * MINUTE - 1 minute =    60,000 milliseconds
 * SECOND - 1 second =     1,000 milliseconds
 * ########################################## */
#define HOUR 2600000
#define MINUTE 60000
#define SECOND 1000


/* ######################################
 * Globals - WiFi
 * 
 * ssid - ssid to connect to,
 *    defined by secrets.h
 * pass - password for a specific network,
 *    if one is needed
 *    if not, will ommit in later call
 * status - WiFi's current status
 * 
 * connect_wifi() - Function Declaration
 * ####################################### */
char ssid[] = SECRET_SSID;
char pass[] = SECRET_PASS;
int status = WL_IDLE_STATUS;
void connect_wifi();

/* ################
 * Database Connect
 * ################ */
IPAddress server(35,227,147,235); 
WiFiClient client;

/* ###############################################
 * Scheduler Setup
 * 
 * Hardset Time Declaration
 *  Setting some defined times that can be swapped
 *    in.
 * Callback Method Prototyping
 *  Used for creating Tasks, will later be defined
 * Task Creation
 *  Initializing Task(to go every hour, forever,
 *    linked to the callback);
 * Scheduler Creation
 *  Initializing the Scheduler that will run everything
 * Callback Defining
 *  The work that the task will accomplish
 * ############################################### */
int five_sec = 5 * SECOND;
int five_min = 5 * MINUTE;
int day = HOUR * 24;

void core_callback();
void check_in_callback();

Task core_task(five_min, TASK_FOREVER, &core_callback);
Task check_in_task(day, TASK_FOREVER, &check_in_callback);

Scheduler runner;

void core_callback()
{
  //DEBUG INFO
  Serial.println("DEBUG: In core_task");
  Serial.print("DEBUG: Time to run in Millisecond - ");
  Serial.println(millis());

  //Iteration Checks
  if (core_task.isFirstIteration()) 
  {
    Serial.println("DEBUG: First Run");
  }

  //should never be true
  if (core_task.isLastIteration()) 
  {
    Serial.println("ERROR: core_task last run");
  }

  //CORE SECTION
  //connect to given Wifi network
  connect_wifi();

  //collect data, connect to database, send data
  post_data();

  //get scheduler time interval, end connection
  check_response();

  //close WiFi connection
  close_wifi();
  
  //Create whitespace to help differentiate
  Serial.println("");
}

void check_in_callback()
{
  //DEBUG INFO
  Serial.println("DEBUG: In check_in_task");
  Serial.print("DEBUG: Time to run in Millisecond - ");
  Serial.println(millis());

  //Iteration Checks
  if (check_in_task.isFirstIteration()) 
  {
    Serial.println("DEBUG: First Run");
  }

  //should never be true
  if (check_in_task.isLastIteration()) 
  {
    Serial.println("ERROR: check_in_task last run");
  }

  //CORE SECTION
  //connect to given Wifi network
  connect_wifi();

  //get scheduler time interval, end connection
  check_response();

  //close WiFi connection
  close_wifi();
  
  //Create whitespace to help differentiate
  Serial.println("");
}


/* ########################
 * Prep Code Section
 *  This runs once on start
 * ######################## */
void setup() 
{
  /* ################################
   * Serial Up
   *  begin Serial connection
   *  hold until the connection is up
   * ################################ */
  Serial.begin(9600);
  //while(!Serial) ;
  Serial.println("DEBUG: Serial Up");  
  
  /* ###############
   * Scheduler Setup
   *  .init - initialize the scheduler
   *  .addTask - add core task to scheduler
   *  delay - 5 seconds to get scheduler up
   *  .enable - start core task
   * ############### */
  runner.init();
  runner.addTask(core_task);
  runner.addTask(check_in_task);
  delay(5000);
  
  core_task.enable();
  Serial.println("DEBUG: Core Task Up");
  Serial.println("");

  check_in_task.enable();
  Serial.println("DEBUG: Check In Task Up");
  Serial.println("");

  /* #########
   * BME Setup
   * ######### */
   bool BME_status;
   BME_status = bme.begin();
   if (!BME_status) {
        Serial.println("ERROR: BME - Could not find a valid BME280 sensor");
        while (1);
   }
}

/* ##############
 * Loop = Main()
 * ############## */
void loop() 
{
  runner.execute();
}

/* ############################################
 * WiFi Connection
 *  while()
 *    prints ssid of attempted connection
 *    attempts connection
 *      pass:   status = WiFi.begin(ssid, pass)
 *      nopass: status = WiFi.begin(ssid)
 *    holds for connection
 *      5000 milliseconds = 5 seconds
 * ############################################ */
void connect_wifi() 
{
  if(WiFi.status() != WL_CONNECTED){
    Serial.println("DEBUG: In WiFi Connect");
    Serial.print("DEBUG: Wifi.Status: ");
    Serial.println(WiFi.status());
    
    while(WiFi.status() != WL_CONNECTED) {
      Serial.print("DEBUG: Attempting to connect to SSID: ");
      Serial.println(ssid);
      status = WiFi.begin(ssid, pass);     
      delay(10000);
    }
    Serial.println("DEBUG: Connected to Network");
    Serial.print("DEBUG: Wifi.Status: ");
    Serial.println(WiFi.status());
  } else {
    Serial.println("ERROR: Connecting to WiFi, already connected");
  }
}

/* ####################################
 * Closes the given WiFi Connection
 *  Considerably easier than connecting
 * #################################### */
void close_wifi()
{
  Serial.println("DEBUG: In WiFi Close");
    
  WiFi.end();
  
  Serial.println("DEBUG: Connection to Network Closed Gracefully");
  Serial.print("DEBUG: Wifi.Status: ");
  Serial.println(WiFi.status());
}


/* #################################################
 * Checks if the device is still connected to wifi
 *  ran each round of task
 *  if not connected, call connect_wifi and attempt,
 *    to connect
 * ################################################# */
void check_wifi()
{
  if(status != WL_CONNECTED)
  {
    Serial.println("ERROR: WiFi - Not Connected to WiFi");
    Serial.println("ERROR: WiFi - Attempting to Connect");
    connect_wifi();
  }
}

/* ############################################
 * Sends information to Database
 *  makes initial variables
 *  makes call to data build_data()
 *  connects to database and sends HTTP request
 * ############################################ */
 void post_data() 
 {
    //core string parts
    String send_start    = "GET ";
    String send_php_page = "/insert_data.php?";
    String send_data;
    String send_end      = " HTTP/1.1";
    String send_full;

    Serial.println("DEBUG: Posting Data");

    send_data = build_data();

    send_full = send_start + send_php_page + send_data + send_end;
    
    // If there's a successful connection, send
    if (client.connect(server, 80)) {
      Serial.println("DEBUG: Connected to Server");
      client.println(send_full);
      client.println("Host: 35.227.147.235");
      client.println("Connection: close");
      client.println();
      Serial.println("DEBUG: Finished Connection");
    } 
    else {
      //Connection failed
      Serial.println("ERROR: Connection Failed");
      client.stop();
    }
}


/* ############################################
 * Get scheduler time
 *  makes a request get scheduler time
 *  waits while it gets everything
 *    closes the connection
 *  requests update
 * ############################################ */
void check_response() 
{
  char reply_interval[10];
  int reply_size = 0;
  bool server_responding = false;
  //has server sent back '#'? This marks int start
  bool hit_marker = false;

  Serial.println("DEBUG: Checking Interval");
  
  // If there's a successful connection, request scheduler time
  if (client.connect(server, 80)) 
  {
    Serial.println("DEBUG: Connected to Server");
    client.println("GET /interval.php HTTP/1.1");
    client.println("Host: 35.227.147.235");
    client.println("Connection: close");
    client.println();
    Serial.println("DEBUG: Finished Connection");
    server_responding = true;
  } 
  else 
  {
    //Connection failed
    Serial.println("ERROR: Connection Failed");
    client.stop();
  }

  //if a connection was made, hold for the response
  while (server_responding)
  {    
    //if client is up and still communicating 
    while (client.available()) 
    {
      char c = client.read();

      //if special marker '#' is found
      if (hit_marker)
      {
        //Buffer overflow check
        if(reply_size > 9)
        {
          //Don't allow buffer overflow
        } else 
        {
          reply_interval[reply_size] = c;
          ++reply_size;
        }
      }

      //marker found, next info is interval
      if (c == '#')
      {
        hit_marker = true;
      }
    }

    // if server disconnected, close connection
    if (!client.connected())
    {
      Serial.println("DEBUG: Disconnecting from Server Gracefully");
      client.stop();
      server_responding = false;
    }
  }

  //validate and update new interval
  update_interval(reply_interval);
}

/* ############################################
 * Updates scheduler time
 *  checks to make sure that the reply is valid
 *  changes the scheduler time
 * ############################################ */
void update_interval(char *reply_interval) 
{
  int new_interval;
  
  //updating scheduler time
  new_interval = atoi(reply_interval);
  if (new_interval == 0)
  {
    //converted reply = 0
    //  could be caused by atoi error
    //  could have been requested, not possible for scheduler
    Serial.println("ERROR: Scheduler Time Returned = 0");
  } else
  {
    Serial.print("DEBUG: Valid Scheduler Interval | Time = ");
    Serial.print(new_interval);
    Serial.println(", Updating");

    core_task.setInterval(new_interval);
  }
}

/* ##################################
 * Builds data string to post
 *  makes calls to sensors
 *  builds data into string with keys
 *    keys defined by database
 * ################################## */
String build_data()
{
  //final string
  String ret_data;

  //database keys
  String key_temp = "temperature=";
  String key_humd = "humidity=";
  String key_pres = "pressure=";
  String key_mstr = "moisture=";
  String key_lite = "light=";
  String key_batt = "battery=";
  String key_ph   = "ph=";

  //string formatting
  String amp      = "&";

  //temp variables
  //  battery level
  //    not implemented yet
  int tmp_bat = 22;
  
  ret_data = key_temp + get_temp() + amp + key_humd + get_humidity() + amp + key_pres + get_pressure() + amp + key_mstr + get_moisture() + amp + key_lite + get_light() + amp + key_batt + tmp_bat;
  Serial.println("DEBUG: Returning Data");
  return ret_data;
}

/* ######################
 * Return BME Temperature
 * ###################### */
int get_temp()
{
  //debug version 
  int ret_temp = bme.readTemperature();
  Serial.print("DEBUG: Temperature Read - ");
  Serial.print(ret_temp);
  Serial.println(" Celsius");
  return ret_temp;
  
  //clean version
  //return bme.readTemperature();
}

/* ###################
 * Return BME Pressure
 * ################### */
int get_pressure()
{
  //debug version 
  int ret_pressure = bme.readPressure();
  Serial.print("DEBUG: Pressure Read - ");
  Serial.print(ret_pressure);
  Serial.println("hPa (Hectopascal)");
  return ret_pressure;
  
  //clean version
  //return bme.readPressure();
}

/* ####################
 * Returns BME Humidity
 * #################### */
int get_humidity()
{
  //debug version 
  int ret_humidity = bme.readHumidity();
  Serial.print("DEBUG: Humidity Read - ");
  Serial.print(ret_humidity);
  Serial.println("% Relative Humitity");
  return ret_humidity;
  
  //clean version
  //return bme.readHumidity();
}

/* ###########################
 * Returns Soil Moisture Level
 * ########################### */
int get_moisture()
{
  //debug version 
  int ret_moisture = analogRead(A1);
  Serial.print("DEBUG: Moisture Read - ");
  Serial.print(ret_moisture);
  Serial.println(" Relative Moisture Level");
  return ret_moisture;
  
  //clean version
  //return analogRead(A1);
}

/* ###################
 * Returns Light Level
 * ################### */
int get_light()
{
  //debug version
  int ret_light = analogRead(A2);
  Serial.print("DEBUG: Light Read - ");
  Serial.print(ret_light);
  Serial.println(" Lux");
  return ret_light;
  
  //clean version
  //return analogRead(A2);
}
