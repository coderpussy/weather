//=============================================================
//Variables for wifi server setup and api keys for IOT
//Constants for WAKE frequency and UOM for sensors
//=============================================================

//===========================================
//Controls supression of the MonPrintf function to serial
//===========================================
#define SerialMonitor
#define ExtendedMQTT

//===========================================
//WiFi connection
//===========================================
const char* ssid = "xxxxxxxx";
const char* pass = "xxxxxxxx";

//===========================================
//MQTT broker connection
//===========================================
//const char* mqttServer = "test.mosquitto.org";
const char* mqttServer = "192.168.5.74";
const int mqttPort = 1883;
const char* mqttUser = "username";
const char* mqttPassword = "password";
const char mainTopic[20] = "MainTopic/";

//===========================================
//Local LAMPP connection
//===========================================
const char* hostUrl = "192.168.5.74";                                                    // The FQDN or IP address of the local storage device on the network.
const char* deviceName = "outdoor";                                                      // The name of the device as it should appear in the local storage output e.g. webpage.
const char* apiKey = "generated_with_generate-password.php";                             // The API key with write permission post data to a local storage. Generated with PHP $hash = password_hash("S47TnP3pp3R", PASSWORD_DEFAULT);

//===========================================
//Metric or Imperial measurements
//===========================================
#define METRIC

//===========================================
//Use optional NVM for backup
//This is a failsafe for RESET events out of
//system control
//===========================================
#define USE_EEPROM

//===========================================
//BME280 altitude offsets (set by user)
//===========================================
#define ALTITUDE_OFFSET_IMPERIAL 5.58
#define ALTITUDE_OFFSET_METRIC 142.6

//===========================================
//BH1750 Enable
//===========================================
#define BH1750Enable

//===========================================
//Anemometer Calibration
//===========================================
//I see 2 switch pulls to GND per revolation. Not sure what others see
#define WIND_TICKS_PER_REVOLUTION 2

//===========================================
//General defines
//===========================================
#define RSSI_INVALID -9999

//===========================================
//Set how often to wake and read sensors
//===========================================
const int UpdateIntervalSeconds = 15 * 60;  //Sleep timer (900s) for my normal operation
//const int UpdateIntervalSeconds = 5 * 60;  //Sleep timer (60s) testing

//===========================================
//Battery calibration
//===========================================
//batteryCalFactor = measured battery voltage/ADC reading
#define batteryCalFactor .0011804
#define batteryLowVoltage 3.3

//===========================================
//Timezone information
//===========================================
const char* ntpServer = "pool.ntp.org";     // Change this if you have a local timesync e.g. fritz.box ;-)
const long  gmtOffset_sec = -7 * 3600;
const int   daylightOffset_sec = 3600;

//===========================================
// Enable MQTT and/or Local storage
//===========================================
//#define EnableMQTT
#define EnableLocal
