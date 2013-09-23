Openbiz use MVC not like other MVC implementation.
Openbiz combine it witdh event drivent programming on Web GUI. 

| Section          | Openbiz                     | Other Framework               |
|------------------|-----------------------------|-------------------------------|
| Front Controller | BizController               | Front_Controller, Application |
| Controller       |                             | Controller                    |
| Action of        | method of form              | method of controller          |
| Model            | DataObject, Service         | Model, ActiveRecord, ORM      |
| View             | View, FOrm & template       | View, template                |


**Note from Rocky Swen :**

Hi Agus,

Thanks for your diligent works! This is huge to the project.
Per your suggestion on MVC, Openbiz MVC is listed below.
- Model: DataObject and Service
- View: View and Form
- Controller
   - Front Controller: BizController
   - Application Controller: Form
   - Action: Form method

It is different with traditional Struts MVC, while closer to that of .Net
and JSF. The name of "Form" is from VB "form".
