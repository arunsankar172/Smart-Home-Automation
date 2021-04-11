//RTC Based Light ON/OFF - Failsafe mode
#include <ESP8266WiFi.h>
#include <espnow.h>
#include <Wire.h>
#include "RTClib.h"
RTC_DS3231 rtc;
uint8_t broadcastAddress[] = {0xA0,0x20,0xA6,0x13,0x46,0x20};
uint8_t r[2]={D1,D2};

typedef struct switch_state {
    int s[7];
} switch_state;


switch_state s_data;

void setup () 
{
  Serial.begin(115200);
  Wire.begin(D3, D7);
  for(int j=0;j<2;j++)
  pinMode(r[j], OUTPUT);
  if (! rtc.begin()) {
    Serial.println("Couldn't find RTC");
    while (1);
  }
  WiFi.mode(WIFI_STA);
  if (esp_now_init() != 0) {
    Serial.println("Error initializing ESP-NOW");
    return;
  }
  esp_now_set_self_role(ESP_NOW_ROLE_CONTROLLER);
  esp_now_register_send_cb(OnDataSent);
  esp_now_add_peer(broadcastAddress, ESP_NOW_ROLE_SLAVE, 1, NULL, 0);
//rtc.adjust(DateTime(F(__DATE__), F(__TIME__)));
  if (rtc.lostPower()) {
    
    Serial.println("RTC lost power, lets set the time!");
//    rtc.adjust(DateTime(F(__DATE__), F(__TIME__)));
    // for example to set January 27 2017 at 12:59 you would call:
//     rtc.adjust(DateTime(2020, 1, 27, 12, 59, 0));
  }
  digitalWrite(r[0],LOW);
}


void OnDataSent(uint8_t *mac_addr, uint8_t sendStatus) {
  Serial.print("Last Packet Send Status: ");
  if (sendStatus == 0){
    Serial.println("Delivery success");
  }
  else{
    Serial.println("Delivery fail");
  }
}


int hr=0,mins=0;
void loop () 
{
    for(int i=0;i<6;i++)
    s_data.s[i]=1;
    DateTime now = rtc.now();
    DateTime off = DateTime(now.year(), now.month(), (now.day()), 6, 0, 0);
    DateTime onn = DateTime(now.year(), now.month(), (now.day()), 18, 0, 0);
    Serial.println("Current Time: ");
    hr=(now.hour());
    mins=(now.minute());
    Serial.print(hr);
    Serial.print(':');
    Serial.print(mins);
    Serial.print(':');
    Serial.print(now.second(), DEC);
    Serial.println();
    if(now>=off&&now<=onn)
    {
      s_data.s[0]=1;
      s_data.s[3]=1;
      s_data.s[5]=1;
      Serial.println("OFF");
    }
    else{
      Serial.println("ON");
      s_data.s[0]=0;
      s_data.s[3]=0;
      s_data.s[5]=0;
    }
    digitalWrite(r[1],s_data.s[5]);
    esp_now_send(broadcastAddress, (uint8_t *) &s_data, sizeof(s_data));
    delay(1000);
}
