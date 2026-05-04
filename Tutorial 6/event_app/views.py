from django.views.generic import ListView, DetailView, CreateView, UpdateView, DeleteView
from django.urls import reverse_lazy
from .models import EventRegistration
from .forms import EventRegistrationForm

class EventListView(ListView):
    model = EventRegistration
    template_name = 'event_list.html'
    context_object_name = 'registrations'

class EventDetailView(DetailView):
    model = EventRegistration
    template_name = 'event_detail.html'
    context_object_name = 'registration'

class EventCreateView(CreateView):
    model = EventRegistration
    form_class = EventRegistrationForm
    template_name = 'event_form.html'
    success_url = reverse_lazy('event_list')

class EventUpdateView(UpdateView):
    model = EventRegistration
    form_class = EventRegistrationForm
    template_name = 'event_form.html'
    success_url = reverse_lazy('event_list')

class EventDeleteView(DeleteView):
    model = EventRegistration
    template_name = 'event_confirm_delete.html'
    success_url = reverse_lazy('event_list')
