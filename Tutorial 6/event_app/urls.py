from django.urls import path
from . import views

urlpatterns = [
    path('', views.EventListView.as_view(), name='event_list'),
    path('register/', views.EventCreateView.as_view(), name='event_create'),
    path('detail/<int:pk>/', views.EventDetailView.as_view(), name='event_detail'),
    path('update/<int:pk>/', views.EventUpdateView.as_view(), name='event_update'),
    path('delete/<int:pk>/', views.EventDeleteView.as_view(), name='event_delete'),
]
