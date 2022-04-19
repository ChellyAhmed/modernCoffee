# sudo pip3 install --upgrade adafruit-python-shell
# wget https://raw.githubusercontent.com/adafruit/Raspberry-Pi-Installer-Scripts/master/raspi-blinka.py
# sudo python3 raspi-blinka.py
# pip3 install adafruit-circuitpython-dht
# sudo apt-get install libgpiod2

import RPi.GPIO as GPIO
import time
import board
import adafruit_dht
import psutil

#Import connector, connect to DB and create cursor
import mysql.connector
try:
    cnx = mysql.connector.connect(user='pi', password='raspberry',
                                  host='192.168.56.123',
                                  database='moderncoffee')
except:
    print("An exception occurred")
if cnx:
    print("connected")
cursor = cnx.cursor()


# We first check if a libgpiod process is running. If yes, we kill it!
for proc in psutil.process_iter():
    if proc.name() == 'libgpiod_pulsein' or proc.name() == 'libgpiod_pulsei':
        proc.kill()
sensor = adafruit_dht.DHT11(board.D23)


def measure_temp():
    temp = sensor.temperature
    return temp


# GPIO.setmode(GPIO.BOARD)
def measure_distance():  # Returns distance in centimeter
    PIN_TRIGGER = 12
    PIN_ECHO = 23

    GPIO.setup(PIN_TRIGGER, GPIO.OUT)
    GPIO.setup(PIN_ECHO, GPIO.IN)
    GPIO.output(PIN_TRIGGER, GPIO.LOW)

    print
    "Waiting for sensor to settle"

    time.sleep(2)
    print
    "Calculating distance"

    GPIO.output(PIN_TRIGGER, GPIO.HIGH)

    time.sleep(0.00001)

    GPIO.output(PIN_TRIGGER, GPIO.LOW)
    while GPIO.input(PIN_ECHO) == 0:
        pulse_start_time = time.time()
    while GPIO.input(PIN_ECHO) == 1:
        pulse_end_time = time.time()

    pulse_duration = pulse_end_time - pulse_start_time

    distance = round(pulse_duration * 17150, 2)

    return distance


measure_temp()
measure_distance()


####NEW CODE STARTS HERE
def measure_coffee():
    dist = measure_distance()
    return dist * 3.14159 * 3.4 * 3.4  # Result in mL


try:
    vol1 = measure_coffee()
    temp1 = measure_temp()
except:
    vol1 = 0
    temp1 = 0
vol2 = vol1
temp2 = temp1
while (True):
    time.sleep(120)
    try:
        vol1 = vol2
        temp1 = temp2
        vol2 = measure_coffee()
        temp2 = measure_temp()
    except:
        vol2 = vol1
        temp2 = temp1
#Send vol2 and temp2 to DB as current temperature and volume as new entries
    try:
        req = "INSERT into coffee(temperature,volume) values (temp2,vol2)"
        cursor.execute(req)
        cnx.commit()
    except:
        print("Error sending date")



We send the sensors data
Better UI/UX
Start the 3D printing