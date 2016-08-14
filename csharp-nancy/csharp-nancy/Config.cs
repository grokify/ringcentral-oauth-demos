using Newtonsoft.Json;
using System.IO;

namespace csharp_nancy
{
    class Config
    {
        private static Config instance = null;
        private Config() { }

        public static Config Instance
        {
            get
            {
                if (instance == null)
                {
                    using (var sr = new StreamReader("config.json"))
                    {
                        var jsonData = sr.ReadToEnd();
                        instance = JsonConvert.DeserializeObject<Config>(jsonData);
                    }
                }
                return instance;
            }
        }

        [JsonProperty("RC_APP_KEY")]
        public string AppKey;

        [JsonProperty("RC_APP_SECRET")]
        public string AppSecret;

        [JsonProperty("RC_APP_SERVER_URL")]
        public string ServerUrl;

        [JsonProperty("RC_APP_REDIRECT_URL")]
        public string RedirectUrl;

        [JsonProperty("MY_APP_HOST")]
        public string AppHost;

        [JsonProperty("MY_APP_PORT")]
        public string AppPort;
    }
}