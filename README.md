<h1 align="center"> Simple Gym System </h1>

## Description

A PHP Laravel web application that uses most of Laravel technologies to build that gym system.The System is based on rules. Admin, City Manager, Gym Manager. All Crud operations running using data tables.

## Content

[System Rules](#system-rules)

[System Features](#system-features)

[User API endpoints](#user-api-endpoints)

[Designs](#designs)

[Web Screenshots](#web)

[API  Screenshots](#api)

[Installation](#installation)

[Contributors](#contributors)

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

```js
    {
        total_training_sessions:1000,
        remaining_training_sessions:300,
    }
```

- endpoint to attend training sessions

- endpoint to see his attendance history

## Designs

### Database ERD

![ERD-Final EED drawio](https://user-images.githubusercontent.com/72627215/158062309-5ea348aa-5a15-4cc8-966b-7cd62e535c4e.svg)

## Screen Shots

### Web

#### Admin Dashboard

![admin 01](https://user-images.githubusercontent.com/72627215/158062403-e6d07d35-0296-4578-ad6a-4ec920da7fd8.jpg)

#### Gyms Datatable

![admin 02](https://user-images.githubusercontent.com/72627215/158062424-993b95db-e370-4637-b472-47d10b0b0b0d.jpg)

#### Training Sessions Datatable

![admin 03](https://user-images.githubusercontent.com/72627215/158062445-62234159-76a1-4e25-a71e-d5e71e47f4c8.jpg)

##### Add Training Session

![Session add](https://user-images.githubusercontent.com/72627215/158062468-2ed3ef20-1121-4eab-9123-bad280c95ef1.jpg)

![Session add with validation](https://user-images.githubusercontent.com/72627215/158062457-b9ef6f7e-1b84-470d-b2b0-443e247ac3d5.jpg)

#### Delete

##### Confirmation

![delete](https://user-images.githubusercontent.com/72627215/158062480-7416a7ca-fcec-42ac-a98c-b1e85d26a31d.jpg)

![delete failed](https://user-images.githubusercontent.com/72627215/158062494-7c39ae2a-22f8-4703-bec2-65efdf9680f5.jpg)

#### Success Message

![edit success](https://user-images.githubusercontent.com/72627215/158062514-9ae1124b-c9bc-45cf-bf7f-9844a469ba76.jpg)

#### Purchase History

![purchase history](https://user-images.githubusercontent.com/72627215/158062528-87058e44-1318-4e01-98cc-4caad1ea9ad9.jpg)

### API

#### Register

![api_register](https://user-images.githubusercontent.com/72627215/158062592-cc06bad8-58bc-4e36-9112-b6a4e3ae9353.jpg)

> After Registeritaion Success Mail Verification send to the user

#### Mail Verifaction

![mail_ver_1](https://user-images.githubusercontent.com/72627215/158062637-9512beea-cba2-431e-988f-990135e6ed8f.jpg)

#### Token Using Sanctum

![token](https://user-images.githubusercontent.com/72627215/158062649-ef6ee4da-cfa3-4673-aaa9-ff601ad28c08.jpg)

#### Verify Mail

![mail_ver_2](https://user-images.githubusercontent.com/72627215/158062687-fc97e864-0ef6-4cd2-9ab0-e244866da6c3.jpg)

#### Welcome Mail After Verification

![mail_welcome](https://user-images.githubusercontent.com/72627215/158062729-745df1b2-448f-465e-b15d-e0ddff1c8975.jpg)

## Installation

1.clone the project

```git
git clone https://github.com/ashrafeldawody/GYM-APP.git
```

2. Run Composer install in the project folder

```bash
composer install
```

3. Copy .env.example file in the project folder

```bash
cp .env.example .env
```

4. install node pacakges

```bash
npm install
npm run dev
```

4. install mysql server

> create database with any name then edit the following in your .env file

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database_name
DB_USERNAME=user_name
DB_PASSWORD=password
```

5. Run the following command

```bash
php artisan key:generate; php artisan migrate --seed; php artisan serve;
```

6. open your browser and open the following link

<http://localhost:8000/>

> if you face any problem don't hasitate to contact us.

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
