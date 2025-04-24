# Project Overview

Project Name: 6amTask Submission By 'Rishad Hossain'.
Panels: Admin (Backend) , User (Frontend)
Run Environment: Full Local System like localhost::8000 port.

## Deployment Details

Prerequisites/Tech Stack : 
  - Laravel 10 + 
  - PHP 8.1 + 
  - composer 2.2+
  - Redis (php_redis 5.3.6-8.1-ts vs16 x64) Or Compatible With Installed & Extension Enabled in PHP

Installation Instructions
# step 1: 
  - clone the project from github, URL: https://github.com/rishad04/6am-mycoder-v4.git
# step 2:
  - Rename File .env.example to .env
  - Rename File Src to 'Public'
# step 3:
  - Run in root directory of the project by any terminal "composer update"
# step 4: 
  - After Successful update run the above commands
    - redis-serve (As some task required redis as casching and .env is set to CACHE_DRIVER=redis)
    - php artisan migrate:fresh --seed (Migrate basic tables and seed basic data for the project) 
    - php artisan serve 
    - php artisan queue:work (As some task required queue's behind the process) 

**All there is well enough to run the project well

# About Project And Tasks (Assuming the project is running in local port at 8000)

Panel Details: There is 2 panel's in this system 1. admin and 2.user. 
Admin panel url:, http://127.0.0.1:8000/admin/login    | Screenshot: https://prnt.sc/ypb3qpwsnBeq
User Panel Url:   http://127.0.0.1:8000/frontend/home  | Screenshot: https://prnt.sc/vxuGQQINHUjL 

Admin Panel Credentials: 
username : superadmin@rishad.com
password : 12345678

User Panel Credentials: 

Need to register as user from url : http://127.0.0.1:8000/frontend/register
Also can be login later :           http://127.0.0.1:8000/frontend/login

Task Description

#  Task 1: Implementing a Subscription Management System with Stripe Integration (Mock)
  -Build a system to manage user subscriptions with different plans and billing cycles.
  -Implement a mock integration with the Stripe API for handling payments and subscription management (you don't need to   interact with the actual Stripe API, focus on the logic and data structures). Simulate successful and failed payment scenarios.
  -Implement basic web routes to subscribe, cancel, and view subscription status.
  -Securely manage API keys and sensitive data (even in a mock scenario, demonstrate best practices).

# Overview of How to Observe Task 1:
The landing page displays subscription plans with pricing and billing cycles. Users can register or log in, then subscribe to a plan. After subscribing, they can view, cancel, or upgrade their plan (e.g., from Basic to Premium), but downgrades are not allowed. This process simulates real-world subscription systems, where users can upgrade but cannot downgrade their plans.
# Verdicts:
Subscription Management System:
Built a system to manage user subscriptions with different plans and billing cycles.
 ** Admin Panel (Backend):
  - Developed a full CRUD system to manage subscription plans, adhering to Laravel best practices (traits, enums, validation, coding standards, etc.).
 ** User Panel (Frontend):
  - Authenticated users can subscribe, view, cancel, and upgrade their plans.

Mock Stripe Integration for Payment Handling:
  - Integrated a mock version of the Stripe API to simulate payment processing and handle subscription management, including successful and failed payment scenarios.

API Key Security:
- Secured sensitive data, including API keys, by storing them in environment variables (.env file).

Basic Web Routes for Subscription Management:
  - Implemented routes for users to subscribe, cancel, and view their subscription status.

# Task 2: Implementing a Basic Real-time Notification System with WebSockets (Simulated)
 - Implement a basic real-time notification system. When a specific action occurs (e.g., a new user registers), simulate broadcasting a notification to online users using Laravel's broadcasting features (you don't need to set up a full WebSocket server like Pusher or Laravel WebSockets, focus on the event and broadcasting logic).
 - Create a simple interface (e.g., a basic web page) to display received notifications.

 # Overview of How to Observe Task 2:
A basic real-time notification system has been implemented. First, log in as an existing user in a regular browser tab (if the user is newly registered, log out and log back in with the registered credentials — this is done for cookie purposes). After logging in, keep that window aside. In an incognito tab, register a new user via the registration page on the frontend. Once the registration is successful, the logged-in user will instantly receive a notification alert. From the menu, they can view the notifications. A simple interface has been implemented to display the received notifications.
# Verdicts:
Real-Time Notification System:
  - Implemented a basic real-time notification system using Laravel’s broadcasting features.
  - When a specific action occurs (e.g., a new user registers), a notification is broadcasted to all online users.

Event and Broadcasting Logic:
  - Focused on the event and broadcasting logic without setting up a full WebSocket server (like Pusher or Laravel WebSockets) can see in storage/logs as log is used for broadcasting channel in local (**queue work running is suggested).
  - Utilized Laravel's built-in event system to simulate notification broadcasting (channel= logs).

User Interface for Notifications:
  - Developed a simple interface to display received notifications.
  - Users can view notifications in real time through a basic web page and menu interface.

# Task 3: Implementing a Caching Strategy for Product Data
  - Identify potential performance bottlenecks in retrieving product information (assume a scenario with a large number of products and frequent access).
  - Implement different caching strategies (e.g., Redis for Laravel's file cache) to improve the performance of fetching product details.
  - Demonstrate the before and after performance (can be through simple time measurements in your code).

# Overview of How to Observe Task 3:
Using the product seeder, over 2000 products are seeded to test performance bottlenecks. On the frontend, two tabs are created: one for the "Product" page and another for the "Product (Cached)" page. In both pages, the time taken for the controller logic to complete is displayed. The tester can open both tabs in separate windows and compare the loading times of the product details page — one from the "Product (Cached)" tab and the other from the regular "Product" tab.
# Verdicts:
Identification of Performance Bottlenecks:
  - Analyzed potential performance bottlenecks when retrieving product information, simulating a scenario with over 2000 products and frequent access.

Caching Strategy Implementation:
  - Implemented caching using Redis and Laravel’s file cache to store product data and improve performance for fetching product details. (redis-server running in terminal is must in local)

Frontend Demonstration of Cached vs. Non-Cached Data:
  - Created two separate tabs on the frontend: one showing the "Product" page with regular data fetching, and another displaying the "Product (Cached)" page where cached data is fetched.
  - Displayed the time taken for the controller logic to complete on both pages for comparison.

Performance Comparison:
 - Demonstrated the before-and-after performance improvements by comparing the loading times of product detail pages from the regular product page versus the cached product page.
 - Tester can test both pages in separate tabs to experience and measure the performance difference.


# Task 4: Building a Basic Task Management System with Queues
  - Create a simple task management system where users can create and view tasks.
  - Implement a process where creating a new task triggers a background job (using Laravel Queues) to send a welcome email to the user who created the task.
  - Demonstrate how to define and process this queued job.

# Overview of How to Observe Task 4:
A Task Management System has been fully developed for authenticated frontend users. After logging in, users can navigate to the 'My Tasks' section from the header menu. In this section, users can:
Create tasks: Allowing users to specify task details.
View their task list: Displaying tasks with pending or completed status.
View task details: Users can click on any task to see more details.
When a user creates a task, a welcome email is automatically sent to their email address (which is used as their username) confirming that the task has been successfully created. This email is sent using a queue, and the email functionality is tested with Mailtrap credentials (for simulating email delivery during development).
From the admin panel, the admin has the ability to update the task status (e.g., mark tasks as completed or change other status details).
# Verdicts:
Task Management System:
 - Developed a simple task management system where users can create and view tasks.
 - Users can view their tasks with pending or completed statuses and can click on a task to view its details.

Background Job with Laravel Queues:
 - Implemented a background job using Laravel Queues that is triggered whenever a user creates a new task.
 - The background job sends a welcome email to the user who created the task, confirming that the task was created successfully.

Email Configuration and Testing:
  - Configured the email functionality using Mailtrap credentials in the .env file for testing queued emails during development.

Queued Job Definition and Processing:
 - Defined the queued job in Laravel and demonstrated how it is processed in the background when a new task is created.
 - Ensured the email is sent asynchronously, improving the overall user experience by not blocking the task creation process.


################# Mock APIs or third-party keys ################ 


STRIPE_SECRET_MOCK=mock_key // if 'always_success' then always will be success 'always_fail' simulaiton will have failed payment alys  

// must be preset to configure stripe mock

STRIPE_API_KEY=sk_test_mocked_123456
STRIPE_SECRET=sh_mocked_secret_key




## These tasks have been completed with a focus on showcasing my logic implementation and problem-solving skills. The aim was to demonstrate the core of my Laravel knowledge and how I approach building functional systems. Please note that design-related aspects may not be perfect, and I request that you focus on the functionality and ignore any design-related mistakes.

## Thank You