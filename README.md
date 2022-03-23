---
sidebar_position: 4
---

# Guild

Guild is a Customer relationship management package that allows the user to manage his leads and deals, similar to a guild that manages its members and their assignments, as well as the reports and plans related to them.

```
```

Providing methods to manage and get leads and CRM related functions.


Methods
==========

Leads
--------

### Create a new lead

```php
/**
 * Create a new Lead
 *
 * @param UserInterface $user
 * @param string $title
 * @param ModelsStages $pipelineStage
 * @param LeadsRotationsAgents $agent
 * @param Organizations $organization
 * @param Types $leadType
 * @param Status $leadStatus
 * @param Source $leadSource
 * @param boolean $isDuplicate
 * @param string $description
 * @return ModelsLeads
 */

    $leads = Leads::create(
        $user,
        $title,
        $modelPipelineStage,
        $leadRotationsAgent,
        $organization,
        $leadType,
        $leadStatus,
        $leadSource,
        $isDuplicate,
        $descriptions
    );

```
### Create a new Lead Attempt

```php

$data = [
    'request' => 'Request Data',
    'ip' => '123.456.789',
    'header' => 'Request Header',
    'source' => 'Source',
    'public_key' => 'Key',
    'processed' => 0,
]

/**
 * Create a new lead attempt
 *
 * @param UserInterface $user
 * @param array $data
 * @param Leads|null $lead
 * @return ModelAttempts
 */
Leads::attempt($user, $data, $lead);
```


### Update

```php

// find a lead by id

$lead = Leads::getById(4, $user);
$lead->Title = 'new Title';
$lead->saveOrFail();

```

### Get Leads


```php

//Get all the leads
$page = 1;
$limit = 10;
$leads = Leads::getAll($user, $page, $limit);

//Get Leads by id
$leads = Leads::getById(4);

//Get leads by status
$leads = Leads::getByStatus(LeadStatus::LOSE, $user, $page, $limit);
$leads = Leads::getByStatus(LeadStatus::WIN, $user, $page, $limit);

```

Organizations
------------------

### Create


```php
//Create a new organization by an array of data
$organization = Organization::create($data, $user);
```

### Update

```php
$organization = Organization::getById(3, $user);
Organization::update($organization, $data);
```

OR

```php
$organization = Organization::getById(3)->update($data);
```

### Get

```php
//Get Organization by its id
$organization = Organization::getById(3, $user);

//Get All organization
$page = 1;
$limit = 10;
$organization = Organization::getAll($user, $page, $limit);
```

### Add Peoples to organization

```php
//Get the people and the organization
$people = Peoples::getById(3);
$organization = Organization::getById(3, $user);

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

Peoples
-------------

### Create
```php
$data = [
    'name' => 'Romeo',
    'email' => 'Romeo@mail.com'
];

$people = People::create($data, $user)
```

### Update
```php
$people = People::getById(1, $user);

$people->name = 'New juan';
$people->saveOrFail();
```
Or
```php
$people = People::getById(1, $user)->update($data);
```
### Create Contact
```php
// @people People user data for the new contact
// @contactType
Contacts::createNewContact($people, $contactType, $value);
```

### Update Contact

Deals
-------------

### Create
```php
$lead = Lead::getById(1, $user);
$newDeal = Deal::create($user, $lead)
```

### Get by Lead
```php
$lead = Lead::getById(1, $user);
$deal = $lead->getDeal();
```

### Get
```php
$deal = Deal::getById(2, $user); 
```

```php
$page = 1;
$limit = 10;
$deal = Deal::getAll($user, $page, $limit);
```

### Update
```php
Deal::update(Deal::getById(2), $data);
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

Rotations
-----------

### Create
```php
$pipelines = Rotations::create($name, $user);
```

### Update
```php
$rotation = Rotations::getById(1);
Rotations::update($rotation, $name);
```

### Get
```php
$rotation = Rotations::getById(1, $user);

$rotation = Rotation::getByName($name, $user);
```

Agents
-----------
### Add
```php
Agents::create($rotation, $user, $receiver, $percent, $hits);
```

### Get Agents
```php
Agents::getAllAgents($rotation, $page, $limit);

Agents::getAgentsFromRotation($rotation, $page, $limit);

Agents::getAgentById(2, $user);
```

### Update Agent
```php
$agent = Rotation::getAgentById(2, $user);
Rotations::update($agent, $data);
```

### Get current agent rotation
```php
Rotation::getAgent($rotation);
```

Activities
--------------
### Create
```php
$activity = Activities::create(
    $user,
    "Title",
    $startDate,
    $endDate,
    $lead,
    $activityType,
    $isComplete,
    $appId
);
```

### Create Activity Type
```php
$type = Activities::createType($user, $name, $description);
```

### Update
```php
$activityEdited = Activities::update($activity, $data);
```

### Get
```php
// Get activity by id
Activities::getById(1, $user);

// Get all activities
Activities::getAll($user, $page, $limit);

// Get leads activities
$lead = Leads::getById(1);

$lead->getActivities();
```