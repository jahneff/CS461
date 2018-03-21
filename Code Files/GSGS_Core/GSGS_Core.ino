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
unsigned long delayTime;

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
void core_callback();
int five_sec = 5 * SECOND;
Task core_task(MINUTE, TASK_FOREVER, &core_callback);
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

  if (core_task.isLastIteration()) 
  {
    Serial.println("ERROR: core_task last run");
  }

  //##################
  //WORK DEFINED BELOW
  //##################
  //dummy work
  //print_wifi_status();

  //connect to given Wifi network
  //  moved from Setup, will make WiFi not be on when connection isn't needed 
  connect_wifi();

  //old version, connect_wifi ensures WiFi connected
  //Is WiFi Connected?
  //check_wifi();

  //collect data, connect to database, send data
  postData();

  //check for database response, end connection
  check_response();

  //close WiFi connection
  close_wifi();
  
  //Create whitespace to help differentiate
  Serial.println("");
}


void setup() 
{
  /* ################################
   * Serial Up
   *  begin Serial connection
   *  hold until the connection is up
   * ################################ */
  Serial.begin(9600);
  while(!Serial) ;
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
  delay(5000);
  core_task.enable();
  Serial.println("DEBUG: Core Task Up");

  /* #########
   * BME Setup
   * ######### */
   bool BME_status;
   BME_status = bme.begin();
   if (!BME_status) {
        Serial.println("ERROR: BME - Could not find a valid BME280 sensor");
        while (1);
   }
   delayTime = 2000;
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
  while(status != WL_CONNECTED) {
    Serial.print("DEBUG: Attempting to connect to SSID: ");
    Serial.println(ssid);
    status = WiFi.begin(ssid, pass);
    delay(10000);
  }
  Serial.println("DEBUG: Connected to Network");
}

/* ####################################
 * Closes the given WiFi Connection
 *  Considerably easier than connecting
 * #################################### */
void close_wifi()
{
  WiFi.end();
  Serial.println("DEBUG: Connection to Network Closed Gracefully");
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


/* ######################################################
 * Prints information about current (possible) connection
 *  current network connected to
 *  current ip address of device
 *  signal strength
 * ###################################################### */
void print_wifi_status()
{
  Serial.print("DEBUG: SSID - ");
  Serial.println(WiFi.SSID());

  IPAddress ip = WiFi.localIP();
  Serial.print("DEBUG: IP Address - ");
  Serial.println(ip);

  long rssi = WiFi.RSSI();
  Serial.print("DEBUG: Signal Strength (RSSI) - ");
  Serial.print(rssi);
  Serial.println(" dBm");
}

/* ############################################
 * Sends information to Database
 *  makes initial variables
 *  makes call to data build_data()
 *  connects to database and sends HTTP request
 * ############################################ */
 void postData() 
 {
    //core string parts
    String send_start    = "GET ";
    String send_php_page = "/insert_data.php?";
    String send_data;
    String send_end      = " HTTP/1.1";
    String send_full;

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


/* #####################################
 * Checks if database call gets response
 *  prints response
 *  closes connection when it's ended
 * ##################################### */
void check_response() 
{
  //if there is a response, print to Serial
  Serial.println("DEBUG: Server Response:");
  while (client.available()) {
    char c = client.read();
    Serial.write(c);
  }

  // if server disconnected, close connection
  if (client.connected()) {
    Serial.println();
    Serial.println("DEBUG: Disconnecting From Server Gracefully");
    client.stop();
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
  String key_batt = "battery=";
  String key_ph   = "ph=";

  //string formatting
  String amp      = "&";

  //temp variables
  //  battery level
  //    not implemented yet
  //  ph
  //    sensor not implemented yet
  int tmp_bat = 22;
  int tmp_ph  = 11;
  int tmp_m   = 3;
  
  ret_data = key_temp + get_temp() + amp + key_humd + get_humidity() + amp + key_pres + get_pressure() + amp + key_mstr + get_moisture() + amp + key_batt + tmp_bat + amp + key_ph + tmp_ph;
  
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
  Serial.println(ret_temp);
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
  Serial.println(ret_pressure);
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
  Serial.println(ret_humidity);
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
  Serial.println(ret_moisture);
  return ret_moisture;
  
  //clean version
  //return analogRead(A1);
}
