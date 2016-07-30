/**
 * Created by ddrdushy on 7/30/2016.
 */

(function(){
    "use strict";


    desc("Default Task");
    task("default",["Version"],function(){
        console.log("\n\nBuild OK!!");
    });

    desc("version check");
    task("Version",function(){
        console.log("Checking Version");

        var packageJson=require("./package.json");
        var expected_version="v4.4.3";
        var actual_version=packageJson.engines.node;

        if(actual_version!==expected_version)
            fail("Incorrect Node version. Expected "+expected_version+ "but Actual "+actual_version);
        console.log(process.version);
    });

}());