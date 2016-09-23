/**
 * Created by ddrdushy on 7/30/2016.
 */

(function(){
    "use strict";

    var semver=require("semver");

    desc("Default Task");
    task("default",["Version"],function(){
        console.log("\n\nBuild OK!!");
    });

    desc("version check");
    task("Version",function(){
        console.log("Checking Version");

        var packageJson=require("./package.json");
        var expected_version=packageJson.engines.node;
        var actual_version=process.version;

        if(semver.neq(expected_version,actual_version))
            fail("Incorrect Node version. Expected "+expected_version+ " but Actual "+actual_version);

    });

}());