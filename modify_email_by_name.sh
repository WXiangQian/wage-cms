#!/bin/sh
#

git filter-branch --force --env-filter '
    if [ "$GIT_COMMITTER_NAME" = "wangxiangqian" ];
    then
        GIT_COMMITTER_NAME="xiangqian";
        GIT_COMMITTER_EMAIL="175023117@qq.com";
        GIT_AUTHOR_NAME="xiangqian";
        GIT_AUTHOR_EMAIL="175023117@qq.com";
    fi' -- --all