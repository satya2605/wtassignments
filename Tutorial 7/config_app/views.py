from django.shortcuts import render, redirect
from django.views.decorators.cache import cache_page
from django.http import HttpResponse
import datetime

# 3. Implement Page Caching (Cache for 60 seconds)
@cache_page(60)
def home_view(request):
    # Retrieve data from session
    username = request.session.get('username', 'Guest')
    
    # Retrieve theme from cookies
    theme = request.COOKIES.get('theme', 'light')
    
    # Get current time to demonstrate caching (this won't update for 60s)
    current_time = datetime.datetime.now()
    
    context = {
        'username': username,
        'theme': theme,
        'current_time': current_time,
    }
    return render(request, 'home.html', context)

# 1. Implement User Preference using Cookies
def set_theme(request):
    theme = request.GET.get('theme', 'light')
    response = redirect('home')
    # Set cookie for 1 year
    response.set_cookie('theme', theme, max_age=365*24*60*60)
    return response

# 2. Implement login session tracking
def login_view(request):
    if request.method == 'POST':
        username = request.POST.get('username')
        # Store in session
        request.session['username'] = username
        return redirect('home')
    return render(request, 'login.html')

def logout_view(request):
    # Destroy the session
    try:
        del request.session['username']
    except KeyError:
        pass
    return redirect('home')
