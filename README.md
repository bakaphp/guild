---
sidebar_position: 4
---

# Guild

Guild is a Customer relationship management package that allows the user to manage his leads and deals, similar to a guild that manages its members and their assignments, as well as the reports and plans related to them.

```
bla bla definition bla bla bla
```

Providing methods to manage and get leads and CRM related functions.

Leads:
- Created / Updated / Delete
- Add activities
- Save Leads attempts

Pipelines:
- Created / Updated / Delete
- Create pipelines stages

Rotations:
- Created / Updated / Delete
- Manage rotation agents

Receivers:
- Created / Updated / Delete
- Assign rotations


Methods
==========

Leads
--------

### Create a new lead

```php
<?php
use kanvas\Guild\Leads;

class Messages implements BaseModel
{
    public function createLead()
    {
        $leads = Leads::create(array $data)
    }
}

```
### Create a new Lead Attempt

```php

class Messages implements BaseModel
{
    public function createLead()
    {
        Leads::attempt($data, $this->request, 'API');
        $leads = Leads::create(array $data)
    }
}
```


### Update

```php

// $data an array with the data that gonna be updated
$lead = Leads::updateById(3, $data)

```
OR

```php

// Update the data from the model after the fetch
$lead = Leads::getById(3)->update($data)

```

### Get Leads


```php

//Get all the leads
$page = 1;
$limit = 10;
$leads = Leads::getAll($page, $limit);

//Get Leads by id
$leads = Leads::getById(4);

//Get leads by status
$leads = Leads::getByStatus(LeadStatus::LOSE);
$leads = Leads::getByStatus(LeadStatus::WIN);

//Get leads by Pipeline stage
// @pipelineStage is a PipelineStage Object
$leads = Leads::getByPipelineStage($pipelineStage);

```

Organizations
------------------

### Create


```php
//Create a new organization by an array of data
$organization = Organization::create($data);
```

### Update

```php
$organization = Organization::updateById(3, $data);
```

OR

```php
$organization = Organization::getById(3)->update($data);
```

### Get

```php
//Get Organization by its id
$organization = Organization::getById(3);

//Get All organization
$page = 1;
$limit = 10;
$organization = Organization::getAll($page, $limit);
```

### Add Peoples to organization

```php
//Get the people and the organization
$people = Peoples::getById(3);
$organization = Organization::getById(3);

// Add a new people to an organization
Organization::addPeople($organization, $people);
```
Or

```php
$organization = Organization::getById(3);
$organization->addPeople($people);
```

### Get Peoples from an Organization

```php
$organization = Organization::getById(3);
$organization->getPeoples();
```
Or
```php
$organization = Organization::getById(3);
Organization::getPeoplesByOrganization($organization);
```

Peoples
-------------

### Create
```php
$people = [
    'name' => 'Romeo',
    'email' => 'Romeo@mail.com'
];

// $user is the user that create the people
// @UserInterface $user
// array $peopleData
$people = People::create($user,$peopleData)
```

### Update
```php
$people = People::getById(1);
People::update($people, $data)
```
Or
```php
$people = People::getById(1)->update($data);
```
### Create Contact
```php
// @people People user data for the new contact
// @contactType
People::createNewContact($people, $contactType, $value);
```

### Update
```php
$people = People::getById(2);
// @people People user data for the new contact
// @contactType
People::updateContact($people, $data);

```
Or

```php
$people = People::getById(2)->update($data);
```
Deals
-------------

### Create
```php
$lead = Lead::getById(1);
$newDeal = Deal::create($lead)
```

### Get by Lead
```php
$lead = Lead::getById(1);
$deal = Deal::getByLead($lead);
```

### Get
```php
$deal = Deal::getById(2); 
```
Or
```php
$page = 1;
$limit = 10;
$deal = Deal::getAll($page, $limit);
```

### Update
```php
Deal::update(Deal::getById(2), $data);
```
Update by object
```php
$deal = Deal::getById(2)->update($data);
```
Update by Lead
```php
$lead = Lead::getById(1);
Deal::getByLead($lead)->update($data);
```

Pipelines
-----------

### Create
```php
$pipelines = Pipelines::create($name, $entity, $user);
```

### Get
```php
$page = 1;
$limit = 10;
$pipelines = Pipelines::getAll($user, $page, $limit);
```
Or
```php
$pipeline = Pipelines::getById($name);
```

### Update
```php
$pipeline = Pipelines::getById(1);
Pipelines::update($pipeline, $name);
```

### Create Stage
```php
// $pipeline Pipeline Object
// $name string
// $hasRotting boolean
// $rottingDays int
Pipelines::createStage($pipeline, $name, $hasRotting, $rottingDays);
```

### Get Stage
```php
$pipelineStage = Pipelines::getStageById(1);
```
Or
```php
$pipelineStage = Pipelines::getStagesByPipeline($pipeline);
```

### Update Stage
```php
$pipelineStage = Pipelines::getStageById(1);
Pipelines::updateStage($pipelineStage, $data)
```
Or
```php
$pipelineStage = Pipelines::getStageById(1)->update($data);
```

Rotations
-----------

### Create
```php
$pipelines = Rotations::create($name);
```

### Update
```php
$rotation = Rotations::getById(1);
Rotations::update($rotation);
```
Or
```php
$rotation = Rotations::getById(1)->update($data);
```
### Get
```php
$rotation = Rotations::getById(1);

$rotation = Rotation::getByName($name);
```

Rotations Agents
-----------
### Add
```php
Rotations::addAgents($rotation, $user, $percent, $hits);
```

### Get Agents
```php
Rotations::getAllAgents($rotation, $page, $limit);

Rotations::getAgentsByUser($user);

Rotation::getAgentById(2);
```

### Edit Agent
```php
$agent = Rotation::getAgentById(2);
Rotations::editRotationAgent($agent, $data);
```