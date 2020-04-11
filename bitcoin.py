#!/usr/bin/env python
from dot3k import backlight

api_key = 'REPLACE'
api_secret = 'REPLACE'
# blue, use (255,0,0) for red,  (0,0,255) for green
backlight.rgb(0, 255, 0)
currency_code = 'USD'  # EUR / any currency code

# don't change below that line
# ----------------------------------------------------------


from coinbase.wallet.client import Client
client = Client(api_key, api_secret)
client.get_exchange_rates()

bitcoinPrice = client.get_spot_price(currency=currency_code)
ethereumPrice = client.get_spot_price(currency_pair= 'ETH-USD')


# clear LCD
import dothat.lcd as lcd
lcd.clear()

# first line
lcd.set_cursor_position(0, 0)
import datetime
datetime.datetime.now()
dateTimeNow = (datetime.datetime.now())
from time import gmtime, strftime
lcd.write('{}'.format(dateTimeNow))

# second line
lcd.set_cursor_position(0, 1)
lcd.write('BTC ${}'.format(bitcoinPrice.amount))

# third line
lcd.set_cursor_position(0, 2)
lcd.write('ETH ${}'.format(ethereumPrice.amount))

# Raspbian uses "hostname -I" to display the ip address on login
# from subprocess import check_output
# ipAdress = check_output(['hostname', '-I'])
# lcd.write('{}'.format(ipAdress))

print 'Bitcoin price %s in %s: %s' % (dateTimeNow, currency_code, bitcoinPrice.amount)

bitcoin price ticker using raspberry pi and displayotron
