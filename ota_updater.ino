#ifdef EnableOTA

#include <HTTPClient.h>
#include <HTTPUpdate.h>

void OTAUpdater() {
  HTTPClient httpClient;
  httpClient.begin(String(otaHost) + ":" + String(otaPort) + String(otaPath));

  t_httpUpdate_return ret = httpUpdate.update(httpClient, otaVersion);
  
  switch(ret) {
      case HTTP_UPDATE_FAILED:
          MonPrintf("Update Error (%d): %s\r\n", httpUpdate.getLastError(), httpUpdate.getLastErrorString().c_str());
          break;
      case HTTP_UPDATE_NO_UPDATES:
          MonPrintf("No update available\n");
          break;
      case HTTP_UPDATE_OK:
          MonPrintf("Update OK\n");
          break;
  }

  httpClient.end();
}

#endif
