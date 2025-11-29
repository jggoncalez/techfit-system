#include <SPI.h>
#include <MFRC522.h>

#define SS_PIN 10
#define RST_PIN 9
MFRC522 mfrc522(SS_PIN, RST_PIN);

void setup() {
  Serial.begin(9600);
  SPI.begin();
  mfrc522.PCD_Init();
  Serial.println("Sistema RFID Iniciado");
}

void loop() {
  // Procura por novos cartões
  if (!mfrc522.PICC_IsNewCardPresent()) {
    return;
  }
  
  // Seleciona um cartão
  if (!mfrc522.PICC_ReadCardSerial()) {
    return;
  }
  
  // Lê o UID
  String uid = "";
  for (byte i = 0; i < mfrc522.uid.size; i++) {
    uid += String(mfrc522.uid.uidByte[i] < 0x10 ? "0" : "");
    uid += String(mfrc522.uid.uidByte[i], HEX);
  }
  uid.toUpperCase();
  
  // Envia dados no formato JSON
  Serial.print("{\"rfid\":\"");
  Serial.print(uid);
  Serial.print("\",\"timestamp\":\"");
  Serial.print(millis());
  Serial.println("\"}");
  
  delay(2000); // Evita leituras duplicadas
}