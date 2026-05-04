from django import forms
from .models import EventRegistration
import re

class EventRegistrationForm(forms.ModelForm):
    class Meta:
        model = EventRegistration
        fields = ['participant_name', 'email', 'event_name', 'contact_number']

    def clean_contact_number(self):
        contact = self.cleaned_data.get('contact_number')
        # Check if contact is exactly 10 digits
        if not re.match(r'^\d{10}$', contact):
            raise forms.ValidationError("Contact number must be exactly 10 digits.")
        return contact

    def clean_email(self):
        email = self.cleaned_data.get('email')
        # Check if email is valid (Django's EmailField does some, but we can add more)
        if "@" not in email:
            raise forms.ValidationError("Please enter a valid email address.")
        return email
