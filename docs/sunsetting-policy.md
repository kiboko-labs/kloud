Versions sunsetting policy, experimental and discontinued support
===

Supported, Experimental and Discontinued images 
---

This tool makes you able to build thousands of images combinations for
5 applications with 2 editions each, for now 6 PHP versions, having each 6
flavors.

This lot of combinations makes the image building process very time-consuming
and requires us to focus on the most used combinations. Thereof we will mark 
in the following chapter the status of the support of the images.

* **✅ available**: This image is fully supported and automatically built by the 
                    CI before being pushed to Docker Hub
* **❌ no support**: The `kloud image:build` command will not make you able to
                     build this combination, probably because the application 
                     version is not compatible with the PHP matching version.
* **🌅️ discontinued**: This version can be built by the `kloud image:build`
                       command, but it is not maintained anymore and not 
                       automatically built and pushed to Docker Hub. You will
                       need to build this image yourself on your environments.
* **⚠️ experimental**: This version can be built by the `kloud image:build`
                       command, but it is not officially supportted by the 
                       application. Use at your own risk. You will be required 
                       to add option `--with-experimental` in order to activate
                       this version combination

Versions Sunsetting Policy
---

In order to maintain only the most used versions combinations, we wil ensure the 
images automatic building will be supported for a 24 months after the initial 
release.

Therefore, the following policy will be applied on all images builds:

| Applications                     | Version | End of builds support |
| -------------------------------- | ------- | --------------------- |
| OroCommerce, OroCRM, OroPlatform | 3.1     | Feb 2022              |
| OroCommerce, OroCRM, OroPlatform | 4.1     | Jan 2023              |
| OroCommerce, OroCRM, OroPlatform | 4.2     | Jan 2024              |
| Marello                          | 2.0     | Feb 2022              |
| Marello                          | 2.1     | Jul 2022              |
| Marello                          | 2.2     | Oct 2022              |
| Marello                          | 3.0     | Feb 2023              |
| Middleware                       | 1.0     | To be defined         |
