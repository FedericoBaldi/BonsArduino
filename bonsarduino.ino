#include <DHT.h>
#define DHTPIN 2                                  // what digital pin we're connected to
#define DHTTYPE DHT22                             // DHT 22  (AM2302), AM2321
#define TIMEOUT     5000                          // mS


String NOME = "*****";                            // Wifi SSID
String PASS = "*****";                            // WiFi Password

DHT dht(DHTPIN, DHTTYPE);

void setup()  
{
  pinMode(13, OUTPUT);
  Serial.begin(115200);                           // Communication with ESP8266 via 3.3V 
  Serial.setTimeout(TIMEOUT);                     // Set the timeout value for the ESP8266
  
  delay(1000);                                    // Delay to complete setup
  Serial.println("AT+RST");                       // Reset
  delay(1000);  
  Serial.println("AT+CWMODE=1");                  // Client mode
  delay(200);  
  Serial.println("AT+CIPMUX=0");                  // Allow a single connection
  delay(200);
    
  String cmd = "AT+CWJAP=\""+NOME+"\",\""+PASS+"\""; //Connect to your AP
  Serial.println(cmd);
  dht.begin();
  delay(500);
}

void loop() 
{
  String cmd;
  // That's for sensor  AM302 DHT22
  // Reading temperature or humidity takes about 250 milliseconds!
  // Sensor readings may also be up to 2 seconds 'old' (its a very slow sensor)
  float h = dht.readHumidity();
  // Read temperature as Celsius (the default)
  float t = dht.readTemperature();
  // Read temperature as Fahrenheit (isFahrenheit = true)
  // float f = dht.readTemperature(true); I dont need it
  float sm = analogRead(0); // Read Soil moisture as analog number
  sm = (sm * 100)/ 1024; // Convert into Percentual number
  float l = analogRead(1); // Read Brightness as analog number
  
  cmd = "AT+CIPSTART=\"TCP\",\"***************.com\",80";   // Establish TCP connection
  Serial.println(cmd);
  delay(200);

  cmd = "GET /insertm.php?vtemp="+String(t)+"&vlux="+String(l)+"&vumidity="+String(h)+"&vsoilmoisture="+String(sm)+" HTTP/1.1"; //I used a simple GET request to save sensors' values in my website
  String cmd2 = "Host: ***************.com"; 
  int requestlenght = cmd.length()+ cmd2.length()+ 6; //Request's lenght + 6(\r\n)
  Serial.println("AT+CIPSEND="+String(requestlenght));
  delay(200);
  Serial.println(cmd);                              // Send the raw HTTP request
  delay(200);
  Serial.println(cmd2);                             // Send the Host of the request
  delay(200);
  
  Serial.println("");
  digitalWrite(13, HIGH);                           // turn the LED to on
  delay(2000);              
  digitalWrite(13, LOW);
  delay(8000);
}
