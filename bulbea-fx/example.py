#! /usr/bin/env python3
import os
import sys
import numpy as np
import bulbea as bb
#import matplotlib.pyplot as pplt
from bulbea.learn.evaluation import split
from bulbea.learn.models import RNN
from sklearn.metrics import mean_squared_error
 
if __name__ == '__main__' :
    if len(sys.argv) != 5:
        print("Usage : python update.py [currency_1] [currency_2] [start_date] [end_date], date format : YYYY-MM-DD")
        sys.exit(0)
    #Get initial object share
    share = bb.Share(source=sys.argv[1], ticker=sys.argv[2], start=sys.argv[3], end=sys.argv[4])

    #Get the data and save to .csv file
    share.update()
    print(share.data.head())
    share.save(filename='{sym}_{start}_{end}.csv'.format(
        sym = '{cur1}{cur2}'.format(
            cur1 = sys.argv[1],
            cur2 = sys.argv[2]
        ),
        start   = sys.argv[3],
        end   = sys.argv[4]
    ))

    #Pre-process
    Xtrain, Xtest, ytrain, ytest = split(share, 'Close', normalize = True)
    Xtrain = np.reshape(Xtrain, (Xtrain.shape[0], Xtrain.shape[1], 1))
    Xtest  = np.reshape( Xtest, ( Xtest.shape[0],  Xtest.shape[1], 1))

    #Train data
    rnn = RNN([1, 100, 100, 1]) # number of neurons in each layer
    rnn.fit(Xtrain, ytrain)

    #Test the model using Xtest
    p = rnn.predict(Xtest)
    print("Mean Square Error : ", mean_squared_error(ytest, p))
