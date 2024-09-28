#ifdef EnableLocal

#include <HTTPClient.h>  // To send HTTP requests.

extern const char* hostUrl;
extern const char* deviceName;
extern const char* apiKey;

//=======================================================================
// SendDataLocal: send data to local network LAMPP stack
//=======================================================================
void SendDataLocal(struct sensorData *environment)
{
  int hourPtr = timeinfo.tm_hour;
  
  String url = String(hostUrl) + "/remote-temperature.php";
  MonPrintf("LocalStorageClient: Sending POST request to LocalStorage at %s\n", url);
  
  String postStr = "";
  postStr += "{ \"apikey\": \"" + String(apiKey) + "\",";
  postStr += "\"name\": \"" + String(deviceName) + "\",";
  postStr += "\"temperature\": \"" + String(environment->BMEtemperature) + "\",";
  postStr += "\"humidity\": \"" + String(environment->humidity) + "\",";
  postStr += "\"pressure\": \"" + String(environment->barometricPressure) + "\",";
  
  #ifdef METRIC
    postStr += "\"temperature_out\": \"" + String(environment->temperatureC) + "\",";
    postStr += "\"rainfall_hourly\": \"" + String(rainfall.hourlyRainfall[hourPtr] * 0.011 * 25.4) + "\",";
    postStr += "\"rainfall_last24\": \"" + String(last24() * 0.011 * 25.4) + "\",";
    postStr += "\"temperature_esp_core\": \"" + String(environment->coreC) + "\",";
  #else
    postStr += "\"temperature_out\": \"" + String(environment->temperatureF) + "\",";
    postStr += "\"rainfall_hourly\": \"" + String(rainfall.hourlyRainfall[hourPtr] * 0.011) + "\",";
    postStr += "\"rainfall_last24\": \"" + String(last24() * 0.011) + "\",";
    postStr += "\"temperature_esp_core\": \"" + String(environment->coreF) + "\",";
  #endif

  postStr += "\"wind_speed\": \"" + String(environment->windSpeed) + "\",";
  postStr += "\"wind_direction\": \"" + String(environment->windDirection) + "\",";
  
  postStr += "\"uv_index\": \"" + String(environment->UVIndex) + "\",";
  postStr += "\"lux\": \"" + String(environment->lux) + "\",";
  
  postStr += "\"boot_count\": \"" + String(bootCount) + "\",";
  postStr += "\"battery\": \"" + String(environment->batteryVoltage) + "\" }";

  MonPrintf("LocalStorageClient: HTTP request body: %s\n", postStr);

  HTTPClient http;
  http.begin(url);
  http.addHeader("Content-Type", "application/json");
  
  int statusCode = http.POST(postStr);
  
  MonPrintf("LocalStorageClient: Received HTTP status code: %d\r\n", statusCode);
  if (statusCode != HTTP_CODE_OK) {
    String responseBody = http.getString();
    MonPrintf("LocalStorageClient: Received HTTP response body: %s\n", responseBody);
  }
  
  http.end();
  delay(1000);
}

#endif
