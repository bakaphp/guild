---
sidebar_position: 4
---

# CRM

Bla bla bla bla bla

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
use kanvas\Crm\Leads;

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
$leads = Leads::getAll();

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
$organization = Organization::getAll();
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

# Controller

Once you have a commentable entity you will need to expose it via a controller, allowing the application to create comments or replies for that given entity.

The first thing you will need to do is 

```php
<?php

class RoomComments
{
    use CommentableController; //or CommentableRoute?

    protected ModelInterface $commentParentEntity;
    protected int|string $parentId;

    /**
     * Set the entity the comment will belong to
     **/
    public function setCommentEntity()
    {
        $this->parentId = (int) $this->router->getParams()['messageId'];
        $this->commentParentEntity = Rooms::findFirst($this->parentId);

        if (!$this->parentId) {
            throw new RuntimeException('Not Found');
        }
}

```

By adding the CommentableController you will have the following functions to use in your routes:

List all comments for he given entity <br />
`- getAll() `

Example: <br />
`- GET  /entity/{id}/comments `

Add a comment to the entity <br />
`- create()`

Example: <br />
`- POST /entity/{id}/comments`

Add a reply to a comment <br />
`- addReply(int $commentId)`

Example: <br />
`- POST /entity/{id}/comments/{id}`

Get a specify Comment <br />
`- getById(int $id)`

Example: <br />
`- GET /entity/{id}/comments/{id}`