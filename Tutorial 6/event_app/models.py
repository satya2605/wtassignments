from django.db import models

class EventRegistration(models.Model):
    participant_name = models.CharField(max_length=100)
    email = models.EmailField()
    event_name = models.CharField(max_length=100)
    registration_date = models.DateField(auto_now_add=True)
    contact_number = models.CharField(max_length=15)

    def __str__(self):
        return f"{self.participant_name} - {self.event_name}"
