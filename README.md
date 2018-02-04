# Lucid • Console
The Console companion for the Lucid Architecture.

## Command Line Interface
The console ships with a command line interface called `lucid` that you can find in `vendor/bin/lucid` and use as
```
lucid make:feature ListUsers Api
```

> To be able to address the `lucid` cli directly you need to have `./vendor/bin` as part of your `$PATH`.
To do that, put this in your shell profile (~/.bash_profile, ~/.zshrc, ~/bashrc) `export PATH="$PATH:./vendor/bin`"

### Available Commands

- `help`             Displays help for a command
- `list`             Lists commands
- **make**
  - `make:controller`  Create a new resource Controller class in a service
  - `make:feature   `  Create a new Feature in a service
  - `make:migration   `  Create a new Migration in a service
  - `make:operation   ` Create a new Operation in a service
  - `make:job       `  Create a new Job in a domain
  - `make:service   `  Create a new Service
  - `make:model     `  Create a new Model
  - `make:request   `  Create a new Request in a service
  - `make:policy   `   Create a new Policy
- **list**
  - `list:features`    List the features.
  - `list:services`    List the services in this project.
- **delete**
  - `delete:feature`   Delete an existing Feature in a service
  - `delete:operation`  Delete an existing Operation in a service
  - `delete:job    `   Delete an existing Job in a domain
  - `delete:service`   Delete an existing Service
  - `delete:model   `  Delete an existing Model
  - `delete:request `  Delete an existing Request in a service
  - `delete:policy  `  Delete an existing Policy
- **src**
  - `src:name       `    Set the source directory namespace.

### Commands Usage

#### Make
- `make:controller <controller> [<service>]`
- `make:migration <migration> <service>`
- `make:feature <feature> [<service>]`
- `make:job <job> <domain> [--queue]`
- `make:service <name>`
- `make:model <model>`
- `make:request <request> [<service>]`
- `make:policy <policy>`

#### List
- `list:services`
- `list:features [<service>]`

#### Delete
- `delete:service <name>`
- `delete:feature <feature> [<service>]`
- `delete:job <job> <domain>`
- `delete:model <model>`
- `delete:request <request> [<service>]`
- `delete:policy <policy>`

#### Set Source Namespace
- `src:name <name>`
