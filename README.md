<h1 align="center"> Simple Gym System </h1>

## Description

A php laravel web application that uses most  of laravel technologies to build that gym system. The System built based on rules and an api for users.

## System Rules

- Admin: admin have access to everything in the system.

- City Manager: can do what Gym Manager do with extra functionalities ...like he can see all gyms in his city and make CRUD on any gym or gym manager in his city.

- Gym Manager:can CRUD training sessiosn and assign coaches to theses sessions.

## System Features

- Buy Package for user throw stripe: any role can buy pacakge for user thorw his visa.

- Statistics: The system provide statistics for the following:

  - pie chart that shows the percent males to females attendance.

  - basic line chart which show how much money we got in 12 months for this year.

  - pie chart to show each city name and how many attendances have been made in his city.

  - pie chart that shows the top 10 users with there bought training Sessions number.

  - All Charts support filering by year.

## User API endpoints

- The system provides an api for users.

- endpoint to register, he needs to enter his (name
,email, gender ,password, password confirmation, date of birth,
profile_image) all of these fields are required.

- after user registeration an email verification link sent to him.

- After user is verified a greeting message is sending to him using queue jobs.

- endpoint to login  by sending him an access token after specifing his email & password

- endpoint to update his profile info

- endpoint to see his remaining training session for example

```json
    {
        total_training_sessions:1000,
        remaining_training_sessions:300,
    }
```

- endpoint to attend training sessions

- endpoint to see his attendance history

## Designs

### Database ERD

<p align="center">
       <img src="https://github.com/AymanxMohamed/Tick-Tac-Toe-Game/blob/main/00%20Project%20Materials/00%20Database/00%20ERD/TicTacToeERD-Final.drawio.svg" alt="Build Status">
</p>
## Contributors

<table>
  <tr>
    <td>
      <img src="https://avatars.githubusercontent.com/u/72627215?v=4"> </img>
    </td>
    <td>
      <img src="https://avatars.githubusercontent.com/u/40903913?v=4"></img>
    </td>
  </tr>
  <tr>
    <td>
      <a href="https://github.com/AymanxMohamed"> Ayman kheirEldeen </a>
    </td>
    <td>
      <a href="https://github.com/ashrafeldawody"> Ashraf Eldawody </a>
    </td>
  </tr>
   <tr>
    <td>
      <img src="https://avatars.githubusercontent.com/u/53107590?v=4"></img>
    </td>
    <td>
      <img src="https://avatars.githubusercontent.com/u/97948998?v=4"></img>
    </td>
  </tr>
  <tr>
    <td>
      <a href="https://github.com/AhmedHafez13"> Ahmed Hafez </a>
    </td>
      <td>
      <a href="https://github.com/amraabdallah"> Amr Abdallah </a>
    </td>
  </tr>
</table>
