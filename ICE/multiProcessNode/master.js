const fs = require("fs"),
  child_process = require("child_process");

/*
child_process provides ability to spawn child processes

each child process implements EventEmitter API, so the parent can register listeners pn the child process
 */

//child_process.spawn()
//spawns the child process asynchronously

console.log("A. child_process.spawn()");
for (let i = 0; i < 3; i++) {
  const workerProcess = child_process.spawn("node", ["support.js", i]);

  //the child process couldn't be spawned
  //the process couldn't be killed
  //sending a message to the child process failed
  workerProcess.on("error", (err) => {
    console.log(`${err.stack}\nError code: ${err.code}\nSignal received: ${err.signal}`)
  });

  workerProcess.stdout.on("data", (data) => {
    console.log(`A. stdout: ${data}`);
  });

  workerProcess.stderr.on("data", (data) => {
    console.log(`A. stderr: ${data}`);
  });

  workerProcess.on("close", (code) => {
    console.log(`A. child process exited with exit code ${code}`);
  });
}

//child_process.exec();
//spawns a separate shell and runs a command within that shell

console.log("B. child_process.exec()");
for (let i = 3; i < 6; i++) {
  const workerProcess = child_process.exec("node support.js " + i, (error, stdout, stderr) => {
    if (error) {
      console.log(`${err.stack}\nError code: ${err.code}\nSignal received: ${err.signal}`);
    }
    if (stdout) {
      console.log("B. stdout:" + stdout);
    }
    if (stderr) {
      console.log("B. stderr:" + stderr);
    }
  });
  workerProcess.on("close", (code) => {
    console.log(`B. child process exited with exit code ${code}`);
  });
}

//child_process.fork();
//spawns a whole new Node.js process with its own VB instance
//and invokes a specified module, with a communication
//channel that allows sending messages between parent and child

console.log("C. child_process.fork()");
for (let i = 6; i < 9; i++) {
  // if silent is true, stdin stdout and stderr of child get piped back to parent
  // if false, which is default, they inherit from parent
  const workerProcess = child_process.fork("support.js", [i], {
    silent: true
  });

  workerProcess.stdout.on("data", (data) => {
    console.log(`C. stdout: ${data}`);
  });

  workerProcess.stderr.on("data", (data) => {
    console.log(`C. stderr: ${data}`);
  });

  workerProcess.on("close", (code) => {
    console.log(`C. child process exited with exit code ${code}`);
  });
}