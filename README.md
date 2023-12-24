Follow this insstruction---------------
1. Run this two command 'composer install', 'npm install'
2. For dummy data run this two command first this 'php artisan db:seed --class=EventSeeder',then this 'php artisan db:seed   --class=EventRegistrationSeeder'
3. After insert dummy data, Run this two command in two terminal (a) php artisan serve (b) npm run dev
4. The task of sending a mail to the user 10 minutes before the start of the event for which the user has registered is done by using the task schedule and queue,job.
