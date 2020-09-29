import matplotlib
import tushare as ts
import pandas as pd
import matplotlib.pyplot as plt
import time
import datetime
import sys
'''
{"code":null,"name":"","time":[],"avps":[],"avns":[],"ratep":[],"raten":[],"lastratep":0,"lastraten":0}
'''

now = str(time.strftime('%Y-%m-%d'))
now_date = datetime.datetime.strptime(now, '%Y-%m-%d')
before_date = now_date-datetime.timedelta(days=12)
before = before_date.strftime('%Y-%m-%d')

fdict = {}
fdict['code'] = sys.argv[1]
fdict['time'] = [];
fdict['opendata'] = [];
fdict['closedata'] = [];


df=ts.get_hist_data(sys.argv[1],start=before,end=now)
close = df.close
open = df.close
for indexs in df.index:
    fdict['time'].append(df.loc[indexs].name)
    fdict['opendata'].append(df.loc[indexs].open)
    fdict['closedata'].append(df.loc[indexs].close)
fdict['code'] = sys.argv[1]
fdict['time'].reverse()
fdict['opendata'].reverse()
fdict['closedata'].reverse()
print(fdict)


