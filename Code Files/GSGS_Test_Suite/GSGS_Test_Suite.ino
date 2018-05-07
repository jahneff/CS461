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

//Header Files
#include "secrets.h"

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
}


/* ##############
 * Loop = Main()
 * ############## */
void loop() 
{
  connect_wifi();
  post_data();
  close_connection();
  close_wifi();
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
 * Updates scheduler time
 *  makes a request get scheduler time
 *  waits while it gets everything
 *    closes the connection
 *  checks to make sure that the reply is valid
 *  changes the scheduler time
 * ############################################ */
void close_connection() 
{
  bool server_responding = true;

  while (server_responding)
  {
    // if server disconnected, close connection
    if (!client.connected())
    {
      Serial.println("DEBUG: Disconnecting from Server Gracefully");
      client.stop();
      server_responding = false;
    }
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

/* #########################
 * Return Static Temperature
 * ######################### */
int get_temp()
{
  int ret_temp = 1;
  return ret_temp;
}

/* ######################
 * Return Static Pressure
 * ###################### */
int get_pressure()
{
  int ret_pressure = 2;
  return ret_pressure;
}

/* #######################
 * Returns Static Humidity
 * ####################### */
int get_humidity()
{
  int ret_humidity = 3;
  return ret_humidity;
}

/* ############################
 * Returns Static Soil Moisture
 * ############################ */
int get_moisture()
{
  int ret_moisture = 4;
  return ret_moisture;
}

/* ##########################
 * Returns Static Light Level
 * ########################## */
int get_light()
{
  int ret_light = 5;
  return ret_light;
}
