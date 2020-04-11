#!/usr/bin/env python
### USER PI AUTOSTART (LCD Display)
# this script gets started by the autologin of the pi user and
# and its output is gets displayed on the LCD

api_key = 'REPLACE'
api_secret = 'REPLACE'
currency_code = 'USD'

color_red='\033[1;31;40m'
color_green='\033[1;32;40m'
color_yellow='\033[1;33;40m'
color_dark_gray='\033[1;30;40m'
color_purple='\033[1;35;40m'
color_blue='\033[1;34;40m'
color_cyan='\033[1;36;40m'

# don't change below that line
# ----------------------------------------------------------
from coinbase.wallet.client import Client
client = Client(api_key, api_secret)
client.get_exchange_rates()

# clear LCD
from os import system
system('clear')

import datetime
d = datetime.datetime.today()
dateTimeNow = d.strftime("%d-%B-%Y %H:%M:%S")
print '%s %s' % (color_red, '{}'.format(dateTimeNow))

bitcoinPrice = client.get_spot_price(currency=currency_code)
print '%s BTC %s %s' % (color_green, currency_code, bitcoinPrice.amount)

ethereumPrice = client.get_spot_price(currency_pair= 'ETH-USD')
print '%s ETH %s %s' % (color_dark_gray, currency_code, ethereumPrice.amount)

ethereumPrice = client.get_spot_price(currency_pair= 'XTZ-USD')
print '%s XTZ %s %s' % (color_purple, currency_code, ethereumPrice.amount)
