import { runCLI } from "@wp-playground/cli";
import fs from "node:fs";
import path from "node:path";
import { fileURLToPath } from "node:url";
import { spawn } from "node:child_process";

const __filename = fileURLToPath(import.meta.url);
const scriptsDir = path.dirname(__filename);
const root = path.resolve(scriptsDir, "..");

const runtimeWordPress = path.join(root, ".runtime", "wordpress");
const themeDir = path.join(root, "theme", "sakhtyar-flow");
const pluginDir = path.join(root, "plugins", "sakhtyar-core");
const contentDir = path.join(root, "content");
const blueprintPath = path.join(root, ".playground", "blueprint.json");

fs.mkdirSync(runtimeWordPress, { recursive: true });
fs.mkdirSync(themeDir, { recursive: true });
fs.mkdirSync(pluginDir, { recursive: true });
fs.mkdirSync(contentDir, { recursive: true });

const blueprint = JSON.parse(fs.readFileSync(blueprintPath, "utf8"));

console.log("");
console.log("==> Starting SakhtYar Flow with WordPress Playground + SQLite");
console.log("    No Docker. No MariaDB. No Apache.");
console.log("");

const cli = await runCLI({
  command: "server",
  port: 8080,
  php: "8.3",
  wp: "latest",
  login: true,
  debug: true,
  "mount-before-install": [
    {
      hostPath: "./.runtime/wordpress",
      vfsPath: "/wordpress"
    }
  ],
  mount: [
    {
      hostPath: "./theme/sakhtyar-flow",
      vfsPath: "/wordpress/wp-content/themes/sakhtyar-flow"
    },
    {
      hostPath: "./plugins/sakhtyar-core",
      vfsPath: "/wordpress/wp-content/plugins/sakhtyar-core"
    },
    {
      hostPath: "./content",
      vfsPath: "/wordpress/wp-content/sakhtyar-content"
    }
  ],
  blueprint
});

console.log("");
console.log("==============================================");
console.log(" SakhtYar Flow is running from IntelliJ");
console.log("==============================================");
console.log(` Site: ${cli.serverUrl}`);
console.log(" Database: SQLite");
console.log(" Runtime: WordPress Playground / PHP-WASM");
console.log(" Live theme: theme/sakhtyar-flow");
console.log(" Live plugin: plugins/sakhtyar-core");
console.log("");
console.log("Save PHP/CSS/JS in IntelliJ and refresh the browser.");
console.log("Use IntelliJ's red Stop button to stop the local site.");
console.log("");

const url = new URL("/", cli.serverUrl).toString();

const openBrowser = () => {
  const platform = process.platform;
  if (platform === "win32") {
    spawn("cmd", ["/c", "start", "", url], { detached: true, stdio: "ignore" }).unref();
  } else if (platform === "darwin") {
    spawn("open", [url], { detached: true, stdio: "ignore" }).unref();
  } else {
    spawn("xdg-open", [url], { detached: true, stdio: "ignore" }).unref();
  }
};
openBrowser();

let shuttingDown = false;
async function shutdown(reason) {
  if (shuttingDown) return;
  shuttingDown = true;
  console.log(`\n==> Stopping SakhtYar Flow (${reason})...`);
  try {
    if (cli?.[Symbol.asyncDispose]) {
      await cli[Symbol.asyncDispose]();
    } else if (cli?.server?.close) {
      await cli.server.close();
    }
  } catch (e) {
    console.error("Cleanup warning:", e?.message ?? e);
  }
  console.log("SakhtYar Flow stopped.");
  process.exit(0);
}

process.on("SIGINT", () => shutdown("SIGINT"));
process.on("SIGTERM", () => shutdown("SIGTERM"));
process.on("SIGHUP", () => shutdown("SIGHUP"));
process.on("uncaughtException", async (err) => {
  console.error(err);
  await shutdown("uncaughtException");
});
process.on("unhandledRejection", async (err) => {
  console.error(err);
  await shutdown("unhandledRejection");
});

// Keep the IntelliJ-owned process alive until Stop is pressed.
await new Promise(() => {});