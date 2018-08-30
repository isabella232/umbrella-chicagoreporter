from tools.fablib import *

from fabric.api import task


"""
Base configuration
"""
env.project_name = 'chicagoreporter'       # name for the project.
env.hosts = ['localhost', ]
env.sftp_deploy = True
env.domain = 'chicagoreporter.test'

"""
Add HipChat info to send a message to a room when new code has been deployed.
"""
env.hipchat_token = ''
env.hipchat_room_id = ''


# Environments
@task
def production():
    """
    Work on production environment
    """
    env.settings    = 'production'
    env.hosts       = [ os.environ['CHICAGOREPORTER_PRODUCTION_SFTP_HOST'], ]    # ssh host for production.
    env.path        = os.environ['CHICAGOREPORTER_PRODUCTION_SFTP_PATH']
    env.user        = os.environ['FLYWHEEL_SFTP_USER']    # ssh user for production.
    env.password    = os.environ['FLYWHEEL_SFTP_PASS']    # ssh password for production.
    env.domain      = 'www.chicagoreporter.com'
    env.port        = '2222'


@task
def staging():
    """
    Work on staging environment
    """
    env.settings    = 'staging'
    env.hosts       = [ os.environ['CHICAGOREPORTER_STAGING_SFTP_HOST'], ]    # ssh host for staging
    env.path        = os.environ['CHICAGOREPORTER_STAGING_SFTP_PATH']
    env.user        = os.environ['FLYWHEEL_SFTP_USER']    # ssh user for production.
    env.password    = os.environ['FLYWHEEL_SFTP_PASS']    # ssh password for production.
    env.domain      = 'staging.fast-plate.flywheelsites.com'  # chicagoreporte.staging.wpengine.com
    env.port        = '2222'

try:
    from local_fabfile import  *
except ImportError:
    pass
