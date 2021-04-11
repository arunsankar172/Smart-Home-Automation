#include <ESP8266WiFi.h>
#include <espnow.h>
uint8_t r[4]={D1,D2,D3,D7};
typedef struct switch_state {
    int s[7];
} switch_state;

switch_state ms_data;
void OnDataRecv(uint8_t * mac, uint8_t *incomingData, uint8_t len) {
  memcpy(&ms_data, incomingData, sizeof(ms_data));
  for(int j=0;j<4;j++){
  Serial.print(ms_data.s[j]);
  digitalWrite(r[j],ms_data.s[j]);
  }
  Serial.println("Recived");
}
 
void setup() {
  for(int j=0;j<4;j++){
  pinMode(r[j], OUTPUT);
  delay(100);
  digitalWrite(r[j],HIGH);
  }

  Serial.begin(115200);
  WiFi.mode(WIFI_STA);
  WiFi.disconnect();
  if (esp_now_init() != 0) {
    Serial.println("Error initializing ESP-NOW");
    return;
  }
  esp_now_set_self_role(ESP_NOW_ROLE_SLAVE);
  esp_now_register_recv_cb(OnDataRecv);
  Serial.println("Started");
}

void loop() {
  
}
