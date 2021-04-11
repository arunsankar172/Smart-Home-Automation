#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
uint8_t r[2]={D1,D2};
const char* ssid = "xxxxxx";
const char* password = "xxxxxxxx";
int s[6];
void setup() {
  Serial.begin(115200);
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  Serial.println("Connecting");
  while(WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());
  for(int j=0;j<2;j++){
  pinMode(r[j], OUTPUT);
//  delay(200);
//  digitalWrite(r[j],HIGH);
  }
}
 
void loop() {
  int s[6];
   String payload;
//   payload="100110";
  if(WiFi.status()== WL_CONNECTED){
      HTTPClient http;
      http.begin("http://65.0.5.138/switch/switch.php");
      int httpResponseCode = http.GET();
//      Serial.println(httpResponseCode);
      payload= http.getString();
      http.end();
    }
  int d= payload.toInt();
//  Serial.println("Data");
//  Serial.println(d);
  
 int l= payload.length();
 int t=l-1; 
  while(d>0){
    s[t]=d%10;
    d=d/10;
    t--;
  }
   for(int j=4;j<l;j++){
    Serial.print(s[j]);
    Serial.print(" ");
    if(s[j]==1){
    digitalWrite(r[j-4],LOW);
    Serial.print(" OFF");
    }
    if(s[j]==0){
    digitalWrite(r[j-4],HIGH);
    Serial.print(" ON");
    } 
  }
  Serial.println();
  l=0;
  payload="";
  delay(1000);
}
