from django.urls import path
from . import views

urlpatterns = [
    path('', views.home_view, name='home'),
    path('set-theme/', views.set_theme, name='set_theme'),
    path('login/', views.login_view, name='login'),
    path('logout/', views.logout_view, name='logout'),
]
