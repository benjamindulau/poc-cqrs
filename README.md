CQRS POC
========

This is an attempt of [CQRS](http://martinfowler.com/bliki/CQRS.html) implementation in a Symfony 2 application.


Quick start
-----------

### Update the parameters file with your local system configuration

```bash
$ cd /path/to/project/root
$ cp app/config/parameters.dist.yml app/config/parameters.yml
$ vi app/config/parameters.yml
```

### Create read/write databases

First make sure to have updated your `parameters.yml` with a correct path for `db.write.path` and `db.read.path`
parameters.

Also make sure that the corresponding directory paths exist!

Then, ask doctrine to create the database and the schema:

```bash
$ app/console doctrine:database:create --connection=write
$ app/console doctrine:schema:create --em=write
```

CQRS Workflow
-------------

### General Workflow

![Workflow](https://raw.github.com/benjamindulau/poc-cqrs/master/workflow.png)

### Registration Workflow

![Workflow](https://raw.github.com/benjamindulau/poc-cqrs/master/registration_workflow.png)