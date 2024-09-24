//=======================================================================
//  sendData: all sensor data in structure is sent to Blynk or Thingspeak
//=======================================================================
void sendData(struct sensorData *environment)
{
  #ifdef EnableMQTT
    SendDataMQTT(environment);
  #endif
  
  #ifdef EnableLocal
    SendDataLocal(environment);
  #endif
}
