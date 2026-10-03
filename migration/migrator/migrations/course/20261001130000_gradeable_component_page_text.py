"""Migration for course database."""


def up(config, database, semester, course):
    """
    Run up migration.

    :param config: Object holding configuration details about Submitty
    :type config: migrator.config.Config
    :param database: Object for interacting with given database for environment
    :type database: migrator.db.Database
    :param semester: Semester of the course being migrated
    :type semester: str
    :param course: Name of course being migrated
    :type course: str
    """
    database.execute("""
        ALTER TABLE gradeable_component
        ALTER COLUMN gc_page TYPE text USING gc_page::text
    """)


def down(config, database, semester, course):
    """
    Run down migration (rollback).

    Multi-page values keep only their first page.

    :param config: Object holding configuration details about Submitty
    :type config: migrator.config.Config
    :param database: Object for interacting with given database for environment
    :type database: migrator.db.Database
    :param semester: Semester of the course being migrated
    :type semester: str
    :param course: Name of course being migrated
    :type course: str
    """
    database.execute("""
        ALTER TABLE gradeable_component
        ALTER COLUMN gc_page TYPE integer
        USING COALESCE(substring(gc_page from '^-?[0-9]+')::integer, 0)
    """)
