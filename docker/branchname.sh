#!/bin/bash

# Extracts the branch name from Github CI Environment
# On Push: returns branch name
# On PR: returns "pr" and appends PR number

if [[ ${GITHUB_EVENT_NAME} == "push" ]]; then
  BUILD_NAME="${GITHUB_REF#refs/heads/}"
else
  PR="$(echo ${GITHUB_REF} | cut -d'/' -f3)"
  BUILD_NAME="pr${PR}"
fi

if [[ ${GITHUB_REF} == "refs/tags/"* ]]; then
  BUILD_NAME=$(sed 's|refs/tags/\(.\+\)|\1|' <<< ${GITHUB_REF})
fi

if [[ ! ${BUILD_NAME} ]]; then
 echo "Failed to get name of branch or pull request" >&2
 echo "DEBUG: GITHUB_EVENT_NAME == ${GITHUB_EVENT_NAME}" >&2
 echo "DEBUG: GITHUB_REF == ${GITHUB_REF}" >&2
fi

echo ${BUILD_NAME}
