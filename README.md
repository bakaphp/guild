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


Add a new Lead
-------------------

Create a new lead

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
Create a new Lead Attempt
-----------------
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


Update Leads
-------------------

```php

// $data an array with the data that gonna be updated
$lead = Leads::updateById(3, $data)

```

Get Leads
-------------------

```php

//Get all the leads
$leads = Leads::getAll();

//Get leads by status
$leads = Leads::getByStatus(LeadStatus::LOSE);
$leads = Leads::getByStatus(LeadStatus::WIN);

//Get leads by Pipeline stage
$leads = Leads::getByStageId(2);

```

HASTA AQUI

```php
//find message
$message = Messages::findFirst(3);

//get all comments
$messageComment = Comments::getAll($message, $page = 1, $limit = 25);
```

Get a Single Comments
-------------------

```php

//find message
$message = Messages::findFirst(3);

//get all the comments of the given entity
$message->getCommentById($id);
```

OR

```php
//find message
$message = Messages::findFirst(3);

//get one by id
$messageComment = Comments::getById($message, $id);

//like the comment
$this->user->likes($messageComment);
```


Delete Comment of a Entity
-------------------

```php

//find message
$message = Messages::findFirst(3);

//delete the comment and verify the user owns it
$message->getCommentById($id)->delete($user);
```

OR

```php
//find message
$message = Messages::findFirst(3);

//delete a comment from this message 
$messageComment = Comments::delete($message, $commentId, $user);
```

OR

```php
//find message
$message = Messages::findFirst(3);

//delete a comment from this message 
$messageComment = Comments::deleteAll($message);
```

Add a Reply to a Comment
-------------------

```php

//find message
$message = Messages::findFirst(3);

//current logged in user , likes now this user
$message->getComment($id)->reply($user, 'text');
```

OR

```php
//find message
$message = Messages::findFirst(3);

//add a comment to the message 
$messageComment = Comments::getById($message, $id)->reply($user, 'text');
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