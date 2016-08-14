using Nancy.Hosting.Self;
using Newtonsoft.Json;
using RazorEngine;
using RazorEngine.Templating;
using RingCentral;
using System;
using System.IO;

namespace csharp_nancy
{
    class Program
    {
        static void Main(string[] args)
        {
            var uri = new Uri(string.Format("http://{0}:{1}", Config.Instance.AppHost, Config.Instance.AppPort));

            using (var host = new NancyHost(uri))
            {
                host.Start();

                Console.WriteLine("Your application is running on " + uri);
                Console.WriteLine("Press any [Enter] to close the host.");
                Console.ReadLine();
            }
        }
    }

    public class DefaultModule : Nancy.NancyModule
    {
        private const string MyState = "myState";

        // must be static. Because every time there is new request, a new instance of this class is created.
        static SDK rcsdk = new SDK(Config.Instance.AppKey,
            Config.Instance.AppSecret,
            Config.Instance.ServerUrl,
            "C# OAuth2 demo app", "1.0.0");

        public DefaultModule()
        {
            var authorizeUri = rcsdk.Platform.AuthorizeUri(Config.Instance.RedirectUrl, MyState);
            var template = File.ReadAllText("index.html");
            Get["/"] = _ =>
            {
                var tokenJson = "";
                var authData = rcsdk.Platform.Auth.GetData();
                if (authData.ContainsKey("access_token") && authData["access_token"] != null)
                {
                    tokenJson = JsonConvert.SerializeObject(authData, Formatting.Indented);
                }
                var page = Engine.Razor.RunCompile(template, "templateKey", null,
                    new { authorize_uri = authorizeUri, redirect_uri = Config.Instance.RedirectUrl, token_json = tokenJson });
                return page;
            };
            Get["/callback"] = _ =>
            {
                var authCode = Request.Query.code.Value;
                rcsdk.Platform.Authenticate(authCode, Config.Instance.RedirectUrl);
                return ""; // js will close this window and reload parent window
            };
        }
    }
}
