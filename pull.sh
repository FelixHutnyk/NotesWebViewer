#!/bin/bash

# Define the path to your repository and branch
repo_path="/home/felixhutnyk/domains/uni.felixhutnyk.com/public_html/"
branch="master"

# Define the directory location for navigation bar generation
nav_loc="/home/felixhutnyk/domains/uni.felixhutnyk.com/public_html/docs/Carleton-University"
nav_output="/home/felixhutnyk/domains/uni.felixhutnyk.com/public_html/docs/Carleton-University/navbar.php"

# Change to the repository directory
cd "$repo_path"

# Fetch the latest changes from the remote repository
git fetch origin "$branch" 2>&1 >> pull.log

# Get the current commit hash of the local branch
current_commit=$(git rev-parse HEAD)

# Get the commit hash of the latest fetched changes
fetched_commit=$(git rev-parse "origin/$branch")

# Compare the commit hashes to check for changes
if [ "$current_commit" != "$fetched_commit" ]; then
    # There are new changes, so pull them
    git pull origin "$branch" >> pull.log
    echo "Updated repository at $(date)" >> pull.log

    # Generate the navigation bar
    generate_nav() {
        local loc="$1"
        local output_file="$2"

        echo "<ul>" > "$output_file"

        for file in "$loc"/*; do
            # Remove leading path and check if it's a hidden file
            local filename="${file##*/}"
            if [[ "$filename" == .* ]]; then
                continue 
            fi

            echo "<li>" >> "$output_file"

            if [ -d "$file" ]; then
                echo "<a class=\"DIR\" style=\"font-weight:bold;\">$filename</a>" >> "$output_file"
                generate_nav "$file" "$output_file"
            else
                echo "<a class=\"NORM\" href=\"$file\">$filename</a>" >> "$output_file"
            fi

            echo "</li>" >> "$output_file"
        done

        echo "</ul>" >> "$output_file"
    }

    # Generate the navigation bar
    generate_nav "$nav_loc" "$nav_output"

    echo "Navigation bar generated."
else
    # No changes, so exit without pulling
    echo "No changes detected at $(date)" >> pull.log
fi
