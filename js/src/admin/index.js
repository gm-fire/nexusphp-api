import app from 'flarum/admin/app';

app.initializers.add('gm-fire/nexusphp-api', () => {
  console.log('[gm-fire/nexusphp-api] Hello, admin!');
});
