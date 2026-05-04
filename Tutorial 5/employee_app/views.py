from django.shortcuts import render, redirect
from django.core.mail import send_mail
from django.conf import settings
from .models import Employee
from .forms import EmployeeForm

def add_employee(request):
    if request.method == 'POST':
        form = EmployeeForm(request.POST)
        if form.is_valid():
            employee = form.save()
            
            # Send Confirmation Email
            subject = 'Registration Successful'
            message = f'Hi {employee.name}, you have been successfully registered in the Employee Management System.'
            email_from = settings.EMAIL_HOST_USER
            recipient_list = [employee.email]
            
            try:
                send_mail(subject, message, email_from, recipient_list)
            except Exception as e:
                print(f"Error sending email: {e}")
            
            # Redirect to employee list after success
            return redirect('employee_list')
    else:
        form = EmployeeForm()
    
    return render(request, 'add_employee.html', {'form': form})

def employee_list(request):
    employees = Employee.objects.all()
    return render(request, 'employee_list.html', {'employees': employees})
