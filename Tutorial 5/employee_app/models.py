from django.db import models

class Employee(models.Model):
    name = models.CharField(max_length=100)
    email = models.EmailField(unique=True)
    phone = models.CharField(max_length=15)
    department = models.CharField(max_length=100)
    salary = models.DecimalField(max_digits=12, decimal_places=2)
    date_of_joining = models.DateField()

    def __str__(self):
        return self.name
