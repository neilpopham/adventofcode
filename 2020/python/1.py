import core

def find_2(numbers):
	l1 = 0
	for n1 in numbers:
		l2 = 0
		for n2 in numbers:
			n1 = int(n1)
			n2 = int(n2)
			if (n1 + n2 == 2020) and (l1 != l2):
				print("%d + %d = 2020. %d x %d = %d" % (n1, n2, n1, n2, n1 * n2))
				return
			l2 += 1
		l1 += 1

def find_3(numbers):
	l1 = 0
	for n1 in numbers:
		l2 = 0
		for n2 in numbers:
			l3 = 0
			for n3 in numbers:	
				n1 = int(n1)
				n2 = int(n2)
				n3 = int(n3)	
				if (n1 + n2 + n3 == 2020) and (l1 != l2) and (l1 != l3) and (l2 != l3):	
					print("%d + %d + %d = 2020. %d x %d x %d = %d" % (n1, n2, n3, n1, n2, n3, n1 * n2 * n3))	
					return
				l3 += 1	
			l2 += 1
		l1 += 1	

numbers = core.load_data("1.txt")

find_2(numbers)

find_3(numbers)
