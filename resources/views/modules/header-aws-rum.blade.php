@if(\App\Helpers\SecretManagerHelper::isAwsSecretManagerActive())
  @if(\App::environment('production'))
    <script>
      (function(n,i,v,r,s,c,x,z){x=window.AwsRumClient={q:[],n:n,i:i,v:v,r:r,c:c};window[n]=function(c,p){x.q.push({c:c,p:p});};z=document.createElement('script');z.async=true;z.src=s;document.head.insertBefore(z,document.head.getElementsByTagName('script')[0]);})(
        'cwr',
        '5018a60a-1a37-4e41-8fed-57c2ca776e23',
        '1.0.0',
        'ap-southeast-1',
        'https://client.rum.us-east-1.amazonaws.com/1.10.0/cwr.js',
        {
          sessionSampleRate: 1,
          guestRoleArn: "arn:aws:iam::019480634551:role/RUM-Monitor-ap-southeast-1-019480634551-4079945287661-Unauth",
          identityPoolId: "ap-southeast-1:4f073b4a-86f4-4d88-b074-c0170db90bf1",
          endpoint: "https://dataplane.rum.ap-southeast-1.amazonaws.com",
          telemetries: ["performance","errors","http"],
          allowCookies: true,
          enableXRay: false
        }
      );
    </script>
  @else
    <script>
      (function(n,i,v,r,s,c,x,z){x=window.AwsRumClient={q:[],n:n,i:i,v:v,r:r,c:c};window[n]=function(c,p){x.q.push({c:c,p:p});};z=document.createElement('script');z.async=true;z.src=s;document.head.insertBefore(z,document.head.getElementsByTagName('script')[0]);})(
        'cwr',
        'e16c5a27-d356-464b-9daf-0e1b771590ac',
        '1.0.0',
        'ap-southeast-1',
        'https://client.rum.us-east-1.amazonaws.com/1.5.x/cwr.js',
        {
          sessionSampleRate: 1,
          guestRoleArn: "arn:aws:iam::263975812908:role/RUM-Monitor-ap-southeast-1-263975812908-0066143030661-Unauth",
          identityPoolId: "ap-southeast-1:1f6f2fbf-08d8-44ef-a0e1-8511cd4326e9",
          endpoint: "https://dataplane.rum.ap-southeast-1.amazonaws.com",
          telemetries: ["performance","errors","http"],
          allowCookies: true,
          enableXRay: true
        }
      );
    </script>
  @endif
@endif