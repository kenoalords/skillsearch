@component('mail::message')
![Submit a job and hire only the best]({{asset('public/job-mail-image.jpg')}} "Submit a job and hire only the best")

Finding the right person for your personal projects can be a real hassle and that is why at [{{ config('app.name') }}]({{config('app.url')}}), we are giving you the oppourtunity to submit your jobs and receive applications from some of the finest skilled people in Nigeria.

# Do you have a project coming up?
Get the best [Makeup Artists](https://skillsearch.com.ng/search?term=Makeup+Artist), [Website Designers](https://skillsearch.com.ng/search?term=Website+Developer), [Graphic Designers](https://skillsearch.com.ng/search?term=Graphics+Designer), [Photographers](https://skillsearch.com.ng/search?term=Photography) and much more on [{{ config('app.name') }}]({{config('app.url')}}) by following this simple steps
1. Signup or Login to your account on [{{ config('app.name') }}]({{config('app.url')}}).
2. Submit your project/job. 
3. Relax and start receiving applications from the best hands
4. Select the best application that falls within your budget and hire immediately

## I don't have an upcoming project or job.
No problem, you can help by **[inviting your friends](https://skillsearch.com.ng/invite)** to join [{{ config('app.name') }}]({{config('app.url')}}) and promote their skills or find skilled people in Nigeria.

It's fun and easy to use

@component('mail::button', ['url' => 'https://skillsearch.com.ng/jobs'])
Submit a Job Today
@endcomponent

Best Regards,<br>
Keno Alordiah from [{{ config('app.name') }}]({{config('app.url')}})
@endcomponent
