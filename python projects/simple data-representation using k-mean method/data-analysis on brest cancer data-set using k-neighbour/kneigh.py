import pandas as pd
from sklearn import cross_validation , neighbors , preprocessing
import numpy as np
df = pd.read_csv("Brest-cancer-wiscinsin.data.txt")

df.replace('?',-99999, inplace=True)

df.drop(['id'],1,inplace=True)

x=np.array(df.drop(['class'],1))

y = np.array(df['class'])

x_train, x_test, y_train, y_test = cross_validation.train_test_split(x,y,test_size=0.6)

clf = neighbors.KNeighborsClassifier()
clf.fit(x_train,y_train)

accuracy = clf.score(x_test,y_test)

print(accuracy)
example_measures = np.array([4,2,1,1,1,2,3,2,1])
example_measures = example_measures.reshape(1,-1)

predict = clf.predict(example_measures)

print(predict)
