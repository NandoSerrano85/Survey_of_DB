import pandas as pd
import numpy as np

def main():
   dt = pd.read_csv("../data/transactions/data.csv")
   modes = dt['mode'].unique()
   answer1 = (0,"")
   for mode in modes:
        cost = dt[(dt['mode'] == mode)]['cost']
        sum = np.sum(cost)
        if sum > answer1[0]:
           answer1 = (sum, mode)
   print "\nWhat is the payment mode that had the lowest total amount of gross revenue?\nThe Answer is: {} with ${:,.2f}\n".format(answer1[1], answer1[0])

   cities = dt['city'].unique()
   answer2 = dict()
   for city in cities:
      cost = dt[(dt['city'] == city)]['cost']
      sum = np.sum(cost)
      answer2[city] = sum
   dt2 = pd.DataFrame(answer2.items(), columns=['City', 'Cost'])
   answer2 = dt2.groupby(['Cost', 'City']).size()[-3:]
   print "Which are the top three cities that had the most total amount of gross revenue?\nThese are:\n{}\n".format(answer2)

   products = dt['product'].unique()
   print "\nHow many distinct product categories are in the data file?\nThe total is: {}".format(len(products))


main()