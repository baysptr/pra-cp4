#include <ESP8266WiFi.h>
#include <ESP8266WiFiMulti.h>
#include <ESP8266HTTPClient.h>
#include <NewPing.h>
#include <Wire.h> 
#include <LiquidCrystal_I2C.h>
#include "DHT.h"

#define DHTPIN 13
#define DHTTYPE DHT22
ESP8266WiFiMulti WiFiMulti;
#define TRIGGER_PIN 2
#define ECHO_PIN 0
#define MAX_DISTANCE 200

NewPing sonar(TRIGGER_PIN, ECHO_PIN, MAX_DISTANCE);
DHT dht(DHTPIN, DHTTYPE);

int timeSinceLastRead = 0;
int relayPin = 13;
int buzzerPin = 16;
int ledPin = 12;

void setup() {
  Serial.begin(115200);

  pinMode(ledPin, OUTPUT);
  pinMode(buzzerPin, OUTPUT);
  pinMode(relayPin, OUTPUT);

  digitalWrite(relayPin, LOW);
  digitalWrite(buzzerPin, LOW);
  digitalWrite(ledPin, LOW);

  WiFi.mode(WIFI_STA);
  WiFi.disconnect();

  WiFiMulti.addAP("LAB-FIK", "UNN@RJ@Y@");
  while((WiFiMulti.run() != WL_CONNECTED)){
    Serial.print(".");
    delay(100);
  }
}

void loop() {
  int nilai_sensor = sonar.ping_cm();
  if(timeSinceLastRead > 2000) {
    float h = dht.readHumidity();
    float t = dht.readTemperature();
    float f = dht.readTemperature(true);
    if (isnan(h) || isnan(t) || isnan(f)) {
      Serial.println("Failed to read from DHT sensor!");
      timeSinceLastRead = 0;
      return;
    }

    float hif = dht.computeHeatIndex(f, h);
    float hic = dht.computeHeatIndex(t, h, false);

    Serial.print("Humidity: ");
    Serial.print(h);
    Serial.print(" %\t");
    Serial.print("Temperature: ");
    Serial.print(hic);
    Serial.print(" *C ");

    if(hic < 30 || h > 70 || h < 40){
      warningFunc();
      Serial.println();
      Serial.print("Jarak: ");
      Serial.println(nilai_sensor);
      if(nilai_sensor <= 20){
        digitalWrite(relayPin, LOW);
        sentRequest((int)h, (int)hic, 0);
//        displayPreview((int)h, (int)hic, 0);
      }else{
        digitalWrite(relayPin, HIGH);
        sentRequest((int)h, (int)hic, 1);
//        displayPreview((int)h, (int)hic, 0);
      }
    }

    timeSinceLastRead = 0;
  }
  delay(100);
  timeSinceLastRead += 100;
}

//void displayPreview(int humidity, int tempC, int saklar){
//  lcd.setCursor(0,0);
//  lcd.print("Kelembapan: ");
//  lcd.print(humidity);
//  lcd.print("%");
//  lcd.setCursor(0,1);
//  lcd.print("Suhu: ");
//  lcd.print(tempC);
//  lcd.print((char)223);
//  lcd.print("C");
//  lcd.setCursor(13,1);
//  if(saklar == 0){
//    lcd.print("OFF");
//  }else{
//    lcd.print("ON");
//  }
//}

void sentRequest(int humidity, int tempC, int saklar){
//  String url = "http://80.211.184.148/suhu/send_data.php?lembab="+humidity+"&cel="+tempC+"&st="+saklar;
  String url = "http://80.211.184.148/suhu/send_data.php?lembab=";
  url += humidity;
  url += "&cel=";
  url += tempC;
  url += "&st=";
  url += saklar;
  
  HTTPClient http;    //Declare object of class HTTPClient

  Serial.println(url); 
  http.begin(url);
//  http.addHeader("Content-Type", "x-www-form-urlencoded");/
 
  int httpCode = http.GET();
  String payload = http.getString();                      
 
  Serial.println(httpCode);
  Serial.println(payload);
 
  http.end();
}

void warningFunc(){
  for(int i=700;i<800;i++){
    tone(buzzerPin,i);
    digitalWrite(ledPin, HIGH);
    delay(15);
  }
  for(int i=800;i>700;i--){
    digitalWrite(ledPin, LOW);
    tone(buzzerPin,i);
    delay(15);
  }
}
