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
 * ############################################################ */
Adafruit_BME280 bme;


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
 * ####################################### */
char ssid[] = SECRET_SSID;
char pass[] = SECRET_PASS;
int status = WL_IDLE_STATUS;


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
Task core_task(five_sec, TASK_FOREVER, &core_callback);

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
    Serial.println("ERROR OCCURED - core_task last run");
  }

  //##################
  //WORK DEFINED BELOW
  //##################
  //dummy work
  //print_wifi_status();
  
  //Is WiFi Connected?
  check_wifi();
  
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

  /* ##########
   * Wifi Setup
   * ########## */
  connect_wifi();
  
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
 * #####EE##################################### */
void connect_wifi() 
{
  while(status != WL_CONNECTED) {
    Serial.print("DEBUG: Attempting to connect to SSID: ");
    Serial.println(ssid);
    status = WiFi.begin(ssid);
    delay(5000);
  }
  Serial.println("DEBUG: Connected to Network");
}


/* #################################################
 * Checks if the device is still connected to wifi
 *  ran each round of task
 *  if not connected, call connect_wifi and attempt,
 *    to connect
 * ################################################# */
void check_wifi(){
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
void print_wifi_status() {
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
