# Logs Directory

This directory contains application logs for security monitoring and debugging.

## Log Files:
- `error.log` - Application errors and exceptions
- `security.log` - Security events and authentication logs
- `app.log` - General application logs

## Security Notes:
- This directory should not be accessible via web browser
- Add .htaccess file to prevent direct access
- Regularly rotate logs to prevent disk space issues
- Monitor logs for suspicious activities

## Log Rotation:
- Logs are automatically rotated when they exceed configured size limits
- Old logs are archived with timestamp suffixes
- Configure retention period based on compliance requirements