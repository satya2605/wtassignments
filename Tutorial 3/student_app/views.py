from django.shortcuts import render
from .models import Student

def student_list(request):
    # Fetch all students from the database using ORM
    students = Student.objects.all()
    
    # Render the data into the HTML template
    return render(request, 'student_list.html', {'students': students})
