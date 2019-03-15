#include <SPI.h>
#include <MFRC522.h>
#include <LiquidCrystal.h>
#include <Servo.h>
#include <DS3231.h>
#define IR 3 
#define RST_PIN   5
#define SS_PIN    53
#define Fan 9
#define light 10

byte readCard[4];
String myTags[100] = {};
int tagsCount = 0;
String tagID = "";
boolean successRead = false;
boolean correctTag = false;
int proximitySensor;
boolean doorOpened = false;
int detection = HIGH;
int LED=13; 
int FLAME= A0;
int BUZZER=4;
int threshold=200;
int firevalue=0;
int num = 0;


DS3231 rtc(SDA, SCL);
MFRC522 mfrc522(SS_PIN, RST_PIN);
LiquidCrystal lcd(40,38,42,44,46,48); 
Servo myServo; 

void setup() {
  Serial.begin(9600);
  pinMode(light, OUTPUT);
  pinMode(8, INPUT);
  pinMode(7, INPUT);
  pinMode(Fan,OUTPUT);
  digitalWrite(Fan,LOW);
  pinMode(LED,OUTPUT);
  pinMode(FLAME,INPUT);
  pinMode(BUZZER,OUTPUT); 
  SPI.begin();  
  mfrc522.PCD_Init(); 
  lcd.begin(16, 2); 
  myServo.attach(37); 
  rtc.begin();
  myServo.write(10);
  lcd.print("-No Master Tag!-");
  lcd.setCursor(0, 1);
  lcd.print("    SCAN NOW");

  while (!successRead) {
    successRead = getID();
    fireDetector();
    if ( successRead == true) {
      myTags[tagsCount] = strdup(tagID.c_str()); 
      lcd.clear();
      lcd.setCursor(0, 0);
      lcd.print("Master Tag Set!");
      tagsCount++;
    }
  }
  successRead = false;
  printMessage();
}

void loop() {
  
        alarmBell();
        fireDetector();
        detection = digitalRead(IR);
        
  if(detection == LOW){
      // Look for new cards
    if ( ! mfrc522.PICC_IsNewCardPresent()) { 
      return;
    }
    // check if the ID has been readed
    if ( ! mfrc522.PICC_ReadCardSerial()) {   
      return;
    }
    tagID = "";
    
      //Get ID of the tag
    for ( uint8_t i = 0; i < 4; i++) {  
      readCard[i] = mfrc522.uid.uidByte[i];
      tagID.concat(String(mfrc522.uid.uidByte[i], HEX)); 
    }
    tagID.toUpperCase();
    mfrc522.PICC_HaltA(); 

    correctTag = false;
    
    if (tagID == myTags[0]) {
      lcd.clear();
      lcd.print("Program mode:");
      lcd.setCursor(0, 1);
      lcd.print("Add/Remove Tag");
      while (!successRead) {
          fireDetector();
          alarmBell();
        successRead = getID();
        if ( successRead == true) {
          for (int i = 0; i < 100; i++) {
            if (tagID == myTags[0]) {
              lcd.clear();
              lcd.setCursor(0, 0);
              lcd.print("You can't remove");
              lcd.setCursor(0, 1);
              lcd.print("Master Tag");
              delay(3000);
              printMessage();
              return;
            }else if (tagID == myTags[i]) {
              myTags[i] = "";
              lcd.clear();
              lcd.setCursor(0, 0);
              lcd.print("  Tag Removed!");
              printMessage();
              return;
            }
          }
          myTags[tagsCount] = strdup(tagID.c_str());
          lcd.clear();
          lcd.setCursor(0, 0);
          lcd.print("   Tag Added!");
          printMessage();
          tagsCount++;
          return;
        }
      }
    }
    successRead = false;
    //check if the tag is registerd or not 
    for (int i = 0; i < 100; i++) {
      if (tagID == myTags[i]) {
        lcd.clear();
        lcd.setCursor(0, 0);
        lcd.print(" Access Granted!");
        myServo.write(170); 
        printMessage();
        correctTag = true;
      }
    }
    if (correctTag == false) {
      lcd.clear();
      lcd.setCursor(0, 0);
      lcd.print(" Access Denied!");
      printMessage();
    }
  }
  
  else { 
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print(" Door Opened!");
   
    while (!doorOpened) {
      CountPll();
      fireDetector();
      alarmBell(); 
      detection = digitalRead(IR);
      if(detection == LOW){
        doorOpened = true;
      }
    }
    doorOpened = false;
    delay(500);
    myServo.write(10); 
    printMessage();
  }
  
}

uint8_t getID() {

  if ( ! mfrc522.PICC_IsNewCardPresent()) { 
    return 0;
  }
  if ( ! mfrc522.PICC_ReadCardSerial()) {   
    return 0;
  }
  tagID = "";
  for ( uint8_t i = 0; i < 4; i++) {  
    readCard[i] = mfrc522.uid.uidByte[i];
    tagID.concat(String(mfrc522.uid.uidByte[i], HEX)); 
  }
  tagID.toUpperCase();
  mfrc522.PICC_HaltA(); 
  return 1;
}


void CountPll(){
  
      if (digitalRead(7) == LOW) {
        if (digitalRead(8) == HIGH) {
                 num++;
                 Serial.print(num);
                 Serial.println(" people in room.");
                 delay(1000);
    }
  }else if (digitalRead(8) == LOW) {
          if (digitalRead(7) == HIGH) {
            if ( num == 0 ){
                  Serial.print(num);
                  Serial.println(" people in room.");
                  delay(1000);
            }else{
                  num--;
                  Serial.print(num);
                  Serial.println(" people in room.");
                  delay(1000);
            }
    }
  }
      if ( num == 0){
        analogWrite(Fan,0);
        digitalWrite(light, LOW);
     }else if ( num <= 8 ){
        analogWrite(Fan,100);
        digitalWrite(light,HIGH);
     }else if ( num <= 15){
        analogWrite(Fan,200);
        digitalWrite(light,HIGH);
     }else if ( num > 15 ){
        analogWrite(Fan,255);
        digitalWrite(light,HIGH);
       }
}
void printMessage() {
  delay(1500);
  lcd.clear();
  lcd.print("-Access Control-");
  lcd.setCursor(0, 1);
  lcd.print(" Scan Your Tag!");

}
void fireDetector(){
  
  firevalue=analogRead(FLAME);
   
  if (firevalue<=threshold) { 
        digitalWrite(LED,HIGH);
        analogWrite(Fan,0);
        digitalWrite(light, LOW); 
    for(int i =0; i<10;i++){
        tone(BUZZER,3000);
        delay(500); 
        noTone(BUZZER);
        delay(500); 
    }
  }else{
        digitalWrite(LED,LOW); 
        noTone(BUZZER);
       }
  }

void alarmBell(){
    String timeNow=rtc.getTimeStr();
        if ( timeNow.substring(3,5) == "00" || timeNow.substring(3,5) == "50"){
          if (timeNow.substring(6,8) == "00" ){
              for(int i =0; i<10;i++){
              tone(BUZZER,3000);
              delay(500); 
              noTone(BUZZER);
              delay(500);
        }
    }
  }
   }
