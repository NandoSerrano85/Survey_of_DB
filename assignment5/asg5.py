import re


struct = dict()
support = dict()
header = '''
************ COP 4722: Survey of Database Systems ************
*                                                            *
*               -- Assignment 5: Data Mining --              *
*                                                            *
**************************************************************
'''
end = '\n\n**************************** END ****************************'

def printformat(min_support, keys, fd):
    fd.write('\n\n**************************** CASE ****************************\n\n')
    key = list()
    value = list()
    layers = dict()
    fd.write("\nMinimum support value: {}\n\n".format(min_support))
    fd.write("   Results of L-1 itemsets:\n")
    for k, v in support.items():
        fd.write("\t%-10s %d\n" % (k, v))
        key.append(k)
        value.append(v)
    fd.write("\n\n   Results of L-2 itemsets:\n")
    layers['L2'] = list()
    for k in range(0, len(key)):
        for k2 in range(0, len(key)):
            if key[k] != key[k2]:
                layers['L2'].append((key[k], key[k2]))
    
    LRunion = 0
    RLunion = 0
    done = list()
    for items in layers['L2']:
        for ks in keys:
            if items[0] in struct[ks]:
                if items[1] in struct[ks]:
                    LRunion += 1
            if items[1] in struct[ks]:
                if items[0] in struct[ks]:
                    RLunion += 1
        tup1 = (items[0], items[1])
        tup2 = (items[1], items[0])
        if LRunion > 0 and (tup1 not in done or tup2 not in done):
            confidence = LRunion/support[items[0]]
            interest = abs(confidence - (support[items[1]]/len(keys)))
            fd.write("\t{}\t{}\t{}\n".format(items[0], items[1], LRunion))
            fd.write("\t   %-6s ==> %s  Confidence = %0.2f, Interest = %0.2f \n" % (items[0], items[1], confidence, interest))
            fd.write("\t\tSupport: LHSuRHS = %0.2f, LHS = %0.2f, RHS = %0.2f \n" % ((LRunion/len(keys)), support[items[0]]/len(keys), support[items[1]]/len(keys)))
            confidence = RLunion/support[items[1]]
            interest = abs(confidence - (support[items[0]]/len(keys)))
            fd.write("\t   %-6s ==> %s  Confidence = %0.2f, Interest = %0.2f \n" % (items[1], items[0], confidence, interest))
            fd.write("\t\tSupport: LHSuRHS = %0.2f, LHS = %0.2f, RHS = %0.2f \n" % ((RLunion/len(keys)), support[items[1]]/len(keys), support[items[0]]/len(keys)))
            done.append((items[0], items[1]))
            done.append((items[1], items[0]))
        LRunion = 0
        RLunion = 0
    done = list()
    found = True
    fd.write("\n   Results of L-3 itemsets:\n")
    for k in range(0, len(key)):
        for k2 in range(0, len(key)):
            for k3 in range(0, len(key)):
                if key[k] != key[k2] and key[k2] != key[k3] and key[k] != key[k3]:
                    for ks in keys:
                        if key[k] in struct[ks] and key[k2] in struct[ks] and key[k3] in struct[ks]:
                            tup1 = (key[k], key[k2], key[k3])
                            tup2 = (key[k], key[k3], key[k2])
                            tup3 = (key[k2], key[k], key[k3])
                            tup4 = (key[k2], key[k3], key[k])
                            tup5 = (key[k3], key[k2], key[k])
                            tup6 = (key[k3], key[k], key[k2])
                            if (tup1 not in done or tup2 not in done or tup3 not in done or tup4 not in done or tup5 not in done or tup6 not in done):
                                fd.write("\t%-10s%-10s%-10s%-10d\n" % (key[k], key[k2], key[k3], 1))
                                done.append((key[k], key[k2], key[k3]))
                                done.append((key[k], key[k3], key[k2]))
                                done.append((key[k2], key[k], key[k3]))
                                done.append((key[k2], key[k3], key[k]))
                                done.append((key[k3], key[k2], key[k]))
                                done.append((key[k3], key[k], key[k2]))
                                found = False
    if(found):
        fd.write(end)
        return
    found = True
    done = list()
    fd.write("\n   Results of L-4 itemsets:\n")
    for k in range(0, len(key)):
        for k2 in range(0, len(key)):
            for k3 in range(0, len(key)):
                for k4 in range(0, len(key)):
                    if key[k] != key[k2] and key[k2] != key[k3] and key[k] != key[k3] and key[k] != key[k4] and key[k2] != key[k4] and key[k3] != key[k4]:
                        for ks in keys:
                            if key[k] in struct[ks] and key[k2] in struct[ks] and key[k3] in struct[ks] and key[k4] in struct[ks]:
                                tup1 = (key[k], key[k2], key[k3], key[k4])
                                tup2 = (key[k], key[k3], key[k2], key[k4])
                                tup3 = (key[k], key[k3], key[k4], key[k2])
                                tup4 = (key[k], key[k4], key[k3], key[k2])
                                tup5 = (key[k], key[k4], key[k2], key[k3])
                                tup6 = (key[k], key[k3], key[k2], key[k4])
                                tup7 = (key[k], key[k2], key[k4], key[k3])
                                tup8 = (key[k2], key[k], key[k3], key[k4])
                                tup9 = (key[k2], key[k3], key[k], key[k4])
                                tup10 = (key[k2], key[k3], key[k4], key[k])
                                tup11 = (key[k2], key[k4], key[k3], key[k])
                                tup12 = (key[k2], key[k4], key[k], key[k3])
                                tup13 = (key[k2], key[k3], key[k], key[k4])
                                tup14 = (key[k2], key[k], key[k4], key[k3])
                                tup15 = (key[k3], key[k2], key[k], key[k4])
                                tup16 = (key[k3], key[k], key[k2], key[k4])
                                tup17 = (key[k3], key[k], key[k4], key[k2])
                                tup18 = (key[k3], key[k4], key[k], key[k2])
                                tup19 = (key[k3], key[k4], key[k2], key[k])
                                tup20 = (key[k3], key[k], key[k2], key[k4])
                                tup21 = (key[k3], key[k2], key[k4], key[k])
                                tup22 = (key[k4], key[k2], key[k3], key[k])
                                tup23 = (key[k4], key[k3], key[k2], key[k])
                                tup24 = (key[k4], key[k3], key[k], key[k2])
                                tup25 = (key[k4], key[k], key[k3], key[k2])
                                tup26 = (key[k4], key[k], key[k2], key[k3])
                                tup27 = (key[k4], key[k3], key[k2], key[k])
                                tup28 = (key[k4], key[k2], key[k], key[k3])

                                if (tup1 not in done or tup2 not in done or tup3 not in done or tup4 not in done or tup5 not in done or tup6 not in done or 
                                    tup7 not in done or tup8 not in done or tup9 not in done or tup10 not in done or tup11 not in done or tup12 not in done or
                                    tup13 not in done or tup14 not in done or tup15 not in done or tup16 not in done or tup17 not in done or tup18 not in done or
                                    tup19 not in done or tup20 not in done or tup21 not in done or tup22 not in done or tup23 not in done or tup24 not in done or
                                    tup25 not in done or tup26 not in done or tup27 not in done or tup28 not in done):
                                    fd.write("\t%-10s%-10s%-10s%-10s%-10d\n" % (key[k], key[k2], key[k3], key[k4], 1))
                                    done.append(tup1)
                                    done.append(tup2)
                                    done.append(tup3)
                                    done.append(tup4)
                                    done.append(tup5)
                                    done.append(tup6)
                                    done.append(tup7)
                                    done.append(tup8)
                                    done.append(tup9)
                                    done.append(tup10)
                                    done.append(tup11)
                                    done.append(tup12)
                                    done.append(tup13)
                                    done.append(tup14)
                                    done.append(tup15)
                                    done.append(tup16)
                                    done.append(tup17)
                                    done.append(tup18)
                                    done.append(tup19)
                                    done.append(tup20)
                                    done.append(tup21)
                                    done.append(tup22)
                                    done.append(tup23)
                                    done.append(tup24)
                                    done.append(tup25)
                                    done.append(tup26)
                                    done.append(tup27)
                                    done.append(tup28)
                                    found = False
                 

    if(found):
        fd.write(end)
        return
    # layer 5
    found = True
    done = list()
    fd.write("\n   Results of L-5 itemsets:\n")

    if(found):
        fd.write(end)
        return



def main():
    with open('output.txt', 'w+') as fd:
        fd.write(header)
        keys = list()
        values = list()
        with open('dataset.txt', 'r') as dt:
            read = dt.read()
            read = read.split()
            min_support = float(read[0])
            for n in range(1, len(read)):
                if n%2 == 1 and read[n] not in keys:
                    struct[read[n]] = list()
                    keys.append(read[n])
                elif n%2 == 0:
                    struct[keys[len(keys)-1]].append(read[n])
                    if values == [] or read[n] not in values:
                        values.append(read[n])
        rounded = round(len(keys) * min_support)
        fd.write('''\n************************* Data Sample ************************\n
    Customer             ItemsPurchased
    ========             ==============
''')
        for k, val in struct.items():
            for v in val:
                fd.write("\t%6s\t\t%16s\n" % (k,v))
        for v in values:
            for k in keys:
                if v in struct[k]:
                    try:
                        support[v] = support[v] + 1
                    except:
                        support[v] = 1
        for v in values:
            if support[v] < rounded:
                del support[v]
        printformat(min_support, keys, fd)
    

main()