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


/* ###################
 * Globals - Variables
 * 
 * HOUR   - 1 hour   = 2,600,000 milliseconds
 * MINUTE - 1 minute =    60,000 milliseconds
 * SECOND - 1 second =     1,000 milliseconds
 * ############## */
#define HOUR 2600000
#define MINUTE 60000
#define SECOND 1000


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
void core_task();

Task task_1(SECOND, TASK_FOREVER, &core_task());

Scheduler runner;

void core_task()
{
  Serial.print("DEBUG: In core_task");
  Serial.print("DEBUG: Time to run in Millisecond - ");
  Serial.print(millis());

  if (task_1.isFirstIteration()) 
  {
      Serial.print("DEBUG: First Run");
  }

  if (task_1.isLastIteration()) 
  {
    Serial.print("DEBUG: ERROR OCCURED - core_task last run");
  }
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
  
  /* ###############
   * WiFi Connection
   * ############### */

  
  /* ###############
   * Scheduler Setup
   * ############### */
   
  
}

void loop() 
{
  // put your main code here, to run repeatedly:

}
