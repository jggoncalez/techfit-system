#include <SPI.h>
#include <MFRC522.h>

#define SS_PIN 10
#define RST_PIN 9

MFRC522 mfrc522(SS_PIN, RST_PIN);

void setup() {
  Serial.begin(9600);
  while (!Serial); // Aguarda porta serial estar pronta
  
  SPI.begin();
  mfrc522.PCD_Init();
  
  Serial.println("Sistema RFID Iniciado");
  Serial.println("Aguardando leituras...");
}

void loop() {
  // Verifica se há novo cartão
  if (!mfrc522.PICC_IsNewCardPresent() || !mfrc522.PICC_ReadCardSerial()) {
    return;
  }
  
  // Monta UID
  String uid = "";
  for (byte i = 0; i < mfrc522.uid.size; i++) {
    if (mfrc522.uid.uidByte[i] < 0x10) uid += "0";
    uid += String(mfrc522.uid.uidByte[i], HEX);
  }
  uid.toUpperCase();
  
  // Envia JSON (uma linha única, sem quebras)
  Serial.print("{\"rfid\":\"");
  Serial.print(uid);
  Serial.println("\"}");
  
  // Halt e delay para evitar duplicatas
  mfrc522.PICC_HaltA();
  mfrc522.PCD_StopCrypto1();
  
  delay(1500);
}