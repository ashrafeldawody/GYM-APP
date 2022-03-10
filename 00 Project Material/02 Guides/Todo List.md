# Project TodoList

- ✔ Cities

  - ✔ Add new City

  - ✔ Edit City name or City Manager

    - ✔ demote CityManager to GeneralManager

    - ✔ promote GeneralManager to CityManager

  - ✔ Delete City only if it has 0 gyms related to it

- 📌 Gyms

  - ⌛ Add new Gym

  - ⌛ Edit Gym data (name, cover_image)

  - ✔ Delete Gym only if it has 0 training sessions

  > All Employees Will have same Edit form That will alow the admin to edit their main informations like name, email, ... etc.
  > we can't delete city manager but we can first change the city manager from cities tab then when he is demoted to general manager we can delete him. => but only if he dosn't have any data related to him or we can restrict deleting him.
- 📌 Employees

  - ✔ Edit Manager Data

    - this will be applied to all employees list except the coach

  - ✔ City Manager

  - 📌 Gym Manager

    - 📌 Add new Gym Manager

    - ⌛ ban and unban gymManager

    - ✔ delete gymManager (soft delete) This action won't delete him it will just demote him to general

  - ✔ General Managers

    - ✔ Add new General Manager

    - 📌 uploading managers image

  - ✔ Coaches

    - ✔ Add New Coach

    - ✔ Edit Coach Name

    - ✔ Delete Coach

      - Check first if he is related to data

- ✔ Users

- ✔ Training Sessions

  - ✔ Add new Training Session (name, day, start time, finish time, coaches(multi select))

    - Check for the overlap

  - ✔ Edit Training Session

    - no restriction on editing name

    - you can't edit the session if their is users attended to it

  - ✔ Delete Training Session

    - can't be deleted if it has attendancies.

- ✔ Attendance Tab

- ✔ Purchase History Tab

- ✔ Revenue Card

- ✔ Packages

  - ✔ Add new package

  - ✔ Edit Package price or session number

  - ✔ Can't delete package if their is some one bought it

    - Check if you edit a certain package price or sessions number it won't affect on the already bought packages.

- ✔ issues

  - fixing cities modal issue on create

