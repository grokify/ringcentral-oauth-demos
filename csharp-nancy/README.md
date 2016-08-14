RingCentral 3-Legged OAuth Demo in CSharp
=========================================

## Overview

This is a quick 3-legged OAuth demo that runs using CSharp and [Nancy](http://nancyfx.org/) with the [RingCentral CSharp SDK](https://github.com/ringcentral/ringcentral-csharp) v0.1.21.

## Installation

The demo is created with Visual Studio 2015 Community Edition and .NET framework v4.6.1. It should also work with Visual Studio 2012 and .NET framework v4.0.

Open the solution file with Visual Studio, build the solution. NuGet packages will be automatically installed.

## Configuration

Edit the `config.json` file to add your application key and application secret.

```powershell
$ cd ringcentral-demos-oauth\csharp-nancy\csharp-nancy
$ cp .\config-sample.json .\bin\Debug\config.json
$ vim .\bin\Debug\config.json
```

In the [Developer Portal](http://developer.ringcentral.com/), ensure the redirect URI in your config file has been entered in your app configuration. By default, the URL is set to the following for this demo:

```
http://localhost:8080/callback
```

## Usage

Run the website by Press <kbd>F5</kbd> inside Visual Studio.

Go to the URL:

```
http://localhost:8080
````

Then click the <input type="button" value="Login with RingCentral"/> button to authorize the demo app and view the access token.


## Possible issues

The demo might throw an exception with the following message:

```
The Nancy self host was unable to start, as no namespace reservation existed for the provided url(s).

Please either enable UrlReservations.CreateAutomatically on the HostConfiguration provided to
the NancyHost, or create the reservations manually with the (elevated) command(s):

netsh http add urlacl url="http://+:8080/" user="Everyone"
```

#### Solution

Run PowerShell as Administrator, execute command `netsh http add urlacl url="http://+:8080/" user="Everyone"`.
